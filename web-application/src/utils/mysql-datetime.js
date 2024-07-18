/**
 * @param {Date} date 
 * @returns {string}
 */
export const mysqlDateTime = date => date?.toISOString().slice(0, 19).replace('T', ' ') ?? null;
