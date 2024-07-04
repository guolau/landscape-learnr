import { isObjectEmpty, filterProperties } from "@components/Utils.js";

/**
 * Removes extra empty rows or adds a new empty row, based on the given list of keys to check.
 * An empty row is considered "extra" if it's got other empty rows before it.
 * @param {Array} rows
 * @param {Array} keysToCheck
 */
export const updateExtraRows = (rows, keysToCheck) => {
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
