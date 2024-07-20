
/**
 * @typedef {Object} SuratTugas
 * @property {string} penanda_tangan
 * @property {string} pembuat_surat
 * @property {string} nomor
 * @property {string} isi_surat
 * @property {string} tanggal_surat
 * @property {string} created_at
 * @property {string} file - Blob base64
 */

/**
 * @typedef {Object} Link
 * @property {string|null} url
 * @property {string} label
 * @property {boolean} active
 */

/**
 * @typedef {Object} KaderGendongResponse
 * @property {number} current_page
 * @property {SuratTugas[]} data
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

export {}