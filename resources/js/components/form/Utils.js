/**
 * Returns the given string in Title Case
 * @param {String} str A string in all lower case, snake case, etc.
 * @returns String
 */
export const toTitleCase = (str) => {
    return str.replace("_", " ").replace(/\w\S*/g, function (txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
};

/**
 * Returns false if all the properties in the given object are falsy.
 * @param {Object} obj
 * @returns Boolean
 */
export const isObjectEmpty = (obj) => {
    return Object.values(obj).every((prop) => !prop);
};

/**
 * Returns a URL for the given asset path.
 * @param {*} path
 * @returns String
 */
export const asset = (path) => {
    var base_path = window._asset || "";
    return base_path + path;
};
