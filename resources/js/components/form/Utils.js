/**
 * Returns the given string in Title Case
 * @param {String} str A string in all lower case, snake case, etc.
 * @returns {String}
 */
export const toTitleCase = (str) => {
    return str.replace("_", " ").replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
};

/**
 * Returns false if all the properties in the given object are falsy.
 * @param {Object} obj
 * @returns {Boolean}
 */
export const isObjectEmpty = (obj) => {
    return Object.values(obj).every((prop) => !prop);
};

/**
 * Returns the given object with only the given keys.
 * @param {Object} obj
 * @param {Array} allowedKeys Keys to keep after filtering
 */
export const filterProperties = (obj, allowedKeys) => {
    if (!obj) {
        return null;
    }

    return Object.keys(obj)
        .filter((key) => allowedKeys.includes(key))
        .reduce((newObj, key) => {
            newObj[key] = obj[key];
            return newObj;
        }, {});
};

/**
 * Removes extra empty rows, based on the given list of keys to check.
 * An empty row is considered "extra" if it's got other empty rows before it.
 * @param {Array} rows
 * @param {Array} keysToCheck
 */
export const removeExtraRows = (rows, keysToCheck) => {
    let last = filterProperties(rows[rows.length - 1], keysToCheck);
    let nextToLast = filterProperties(rows[rows.length - 2], keysToCheck);

    if (rows.length > 1 && isObjectEmpty(last) && isObjectEmpty(nextToLast)) {
        rows.pop();
    } else if (!last || !isObjectEmpty(last)) {
        // create an empty object and append to end of row
        let obj = {};

        keysToCheck.forEach((key) => {
            obj[key] = null;
        });

        rows.push(obj);
    }
};

/**
 * Remove all empty rows, based on the given list of keys to check.
 * @param {Array} rows
 * @param {Array} keysToCheck
 * @return {Array}
 */
export const filterEmptyRows = (rows, keysToCheck) => {
    return rows.filter((obj) => {
        obj = filterProperties(obj, keysToCheck);
        return !isObjectEmpty(obj);
    });
};

/**
 * Returns a URL for the given asset path.
 * @param {String} path
 * @returns {String}
 */
export const asset = (path) => {
    if (!path) return null;

    var base_path = window._asset || "";
    return base_path + path;
};

/**
 * Returns the relative format of the given date, relative to now.
 * @param {Date|String} path
 * @returns {String}
 */
export const formatRelativeDate = (date) => {
    const msPerMinute = 60 * 1000;
    const msPerHour = msPerMinute * 60;
    const msPerDay = msPerHour * 24;
    const msPerMonth = msPerDay * 30;
    const msPerYear = msPerDay * 365;

    let now = new Date();
    date = typeof date == "string" ? new Date(date) : date;
    let msDiff = now - date;

    let unit;
    let count;

    if (date == null) {
        return "never";
    } else if (msDiff < msPerMinute) {
        return "a few seconds ago";
    } else if (msDiff < msPerHour) {
        unit = "minute";
        count = msDiff / msPerMinute;
    } else if (msDiff < msPerDay) {
        unit = "hour";
        count = msDiff / msPerHour;
    } else if (msDiff < msPerMonth) {
        unit = "day";
        count = msDiff / msPerDay;
    } else if (msDiff < msPerYear) {
        unit = "month";
        count = msDiff / msPerMonth;
    } else {
        unit = "year";
        count = msDiff / msPerYear;
    }

    const rtf = new Intl.RelativeTimeFormat("en", {
        localeMatcher: "best fit",
        numeric: "always",
        style: "long",
    });

    return rtf.format(Math.round(-1 * count), unit);
};

/**
 * Returns a human-readable format of the given date.
 * @param {Date|String} date
 * @param {Object} formatOpts
 * @returns {String}
 */
export const formatDate = (date, formatOpts = null) => {
    date = typeof date == "string" ? new Date(date) : date;
    formatOpts = formatOpts || {
        dateStyle: "short",
        timeStyle: "short",
    };
    return date ? new Intl.DateTimeFormat("en", formatOpts).format(date) : "";
};
