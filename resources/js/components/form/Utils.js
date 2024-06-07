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
