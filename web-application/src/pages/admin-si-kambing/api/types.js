
/**
 * @typedef {Object} Produk
 * @property {number} id - The unique identifier for the product.
 * @property {string} nomor_telepon - The contact phone number for inquiries about the product.
 * @property {string} nama - The name of the product.
 * @property {string} deskripsi - A detailed HTML description of the product.
 * @property {string} overview - A brief overview of the product.
 * @property {Array<string>} tags - An array of tags related to the product.
 * @property {number} harga - The price of the product in Indonesian Rupiah.
 * @property {string} gambar - The URL path to the product image.
 * @property {boolean} sedang_dijual - Indicates if the product is currently for sale.
 * @property {boolean} pin - Indicates if the product is pinned or highlighted.
 */


/**
 * @typedef {Object} CreateProduk
 * @property {string} nomor_telepon - The contact phone number for inquiries about the product.
 * @property {string} nama - The name of the product.
 * @property {string} deskripsi - A detailed HTML description of the product.
 * @property {string} overview - A brief overview of the product.
 * @property {Array<string>} tags - An array of tags related to the product.
 * @property {number} harga - The price of the product in Indonesian Rupiah.
 * @property {string} gambar - The URL path to the product image.
 * @property {boolean} sedang_dijual - Indicates if the product is currently for sale.
 * @property {boolean} pin - Indicates if the product is pinned or highlighted.
 */

/**
 * @typedef {Object} ProdukResponse
 * @property {number} current_page
 * @property {Produk[]} data
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