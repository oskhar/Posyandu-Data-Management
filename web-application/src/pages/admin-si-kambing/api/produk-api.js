import { getFullImagePath } from "@/utils/get-full-image-path";
import { useProdukStore } from "@/utils/kambing-fake-store";

export const getListProduk = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
	tags = [],
}) => {
	const produkStore = useProdukStore();

	return new Promise(resolve => {
		const produk = produkStore.searchProduk({ tags, search, page, length: lengthPerPage })

		produk.listProduk = produk.listProduk.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }))

		setTimeout(() => resolve(produk), 1000);
	})
}

export const getDetailProduk = async id => {
	const parsedId = parseInt(id);
	const produkStore = useProdukStore();

	return new Promise(resolve => {
		const produk = produkStore.readProduk(parsedId)

		produk.gambar = getFullImagePath(produk.gambar)

		setTimeout(() => resolve(produk), 1000);	
	})
}

/**
 * @param {import("./types").CreateProduk} produk 
 */
export const createProduk = async produk => {
	const produkStore = useProdukStore();

  new Promise(resolve => {
    setTimeout(() => {
      produkStore.createProduk(produk);
      resolve()
    }, 1000);
  })
}


/**
 * @param {string} id 
 * @param {import("./types").CreateProduk} produk 
 */
export const editProduk = async (id, produk) => {
	const idProduk = parseInt(id);
	const produkStore = useProdukStore();

  new Promise(resolve => {
    setTimeout(() => {
      produkStore.updateProduk(idProduk, produk);
      resolve()
    }, 1000);
  })
}

/**
 * @param {string} id 
 */
export const deleteProduk = async id => {
	const idProduk = parseInt(id);
	const produkStore = useProdukStore();

  new Promise(resolve => {
    setTimeout(() => {
      produkStore.deleteProduk(idProduk);
      resolve()
    }, 1000);
  })
}

export const getTags = async () => {
	const produkStore = useProdukStore();

	return new Promise(resolve => {
		setTimeout(() => resolve(produkStore.tags), 1000);
	})
}