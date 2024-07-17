
/**
 * @typedef {Object} Tantangan
 * @property {number} id
 * @property {string} judul
 * @property {string} gambar - Base64 picture
 * @property {string} overview
 * @property {string} deskripsi - HTML string
 * @property {string} tanggal_mulai
 * @property {string} tanggal_selesai
 */

/**
 * @typedef {Object} CreateTantangan
 * @property {string} judul
 * @property {string} gambar - Base64 picture
 * @property {string} overview
 * @property {string} deskripsi - HTML string
 * @property {string} tanggal_mulai
 * @property {string} tanggal_selesai
 */

/**
 * @typedef {Object} TantanganResponse
 * @property {number} current_page
 * @property {Tantangan[]} data
 * @property {string} first_page_url
 * @property {number} from
 * @property {number} last_page
 * @property {string} last_page_url
 * @property {Link[]} links
 * @property {string|null} next_page_url
 * @property {string} path
 * @property {number} per_page
 * @property {string|null} prev_page_url
 * @property {number} to
 * @property {number} total
 */


/**
 * @typedef {Object} Submission
 * @property {number} id
 * @property {number} tantangan_id
 * @property {string} file
 * @property {string} link
 * @property {} status
 */
export {}