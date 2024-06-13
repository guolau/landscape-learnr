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
    console.log(
        obj,
        Object.values(obj).every((prop) => !prop),
    );
    return Object.values(obj).every((prop) => !prop);
};
