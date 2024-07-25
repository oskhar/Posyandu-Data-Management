/**
 * @typedef {Object} Product
 * @property {number} id - The unique identifier for the product.
 * @property {string} nomor_telepon - The contact phone number for inquiries.
 * @property {string} nama - The name of the product.
 * @property {string} deskripsi - A detailed description of the product, including HTML content.
 * @property {string} overview - A brief overview of the product.
 * @property {string[]} tags - An array of tags associated with the product.
 * @property {number} harga - The price of the product in Indonesian Rupiah.
 * @property {string} gambar - The URL to the product's image.
 * @property {boolean} sedang_dijual - A flag indicating whether the product is currently for sale.
 * @property {boolean} pin - A flag indicating whether the product is pinned for promotion.
 */

/**
 * @typedef {Object} ProductResponse
 * @property {number} current_page
 * @property {Product[]} data
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