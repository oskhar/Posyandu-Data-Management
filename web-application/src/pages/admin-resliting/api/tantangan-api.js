import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path";

/**
 * @param {{search: string; length: number; page: number}} param0 
 */
export const getListTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	const { data } = await api.get('/resleting/tantangan', {
    params: { page, length: lengthPerPage, search },
  }) 

  /** @type {import("./types").TantanganResponse} */
	const dataResponse = data;

  dataResponse.data = dataResponse.data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));

  return dataResponse;
}


/**
 * @param {string} id 
 */
export const getSingleTantangan = async id => {
  const { data } = await api.get(`/resleting/tantangan/${id}`);

  /** @type {  import("./types").Tantangan} */
	const dataResponse = data;

  dataResponse.gambar = getFullImagePath(dataResponse.gambar) 


	return dataResponse;
}

/**
 * @param {import("./types").CreateTantangan} tantangan 
 */
export const createTantangan = async tantangan => {
	const { data } = await api.post("/resleting/tantangan", tantangan);

  return data;
}


/**
 * @param {string} id 
 * @param {import("./types").CreateTantangan} tantangan 
 */
export const editListTantangan = async (id, tantangan) => {
	const { data } = await api.put(`/resleting/tantangan/${id}`, tantangan);

  return data;
}

/**
 * @param {string} id 
 */
export const deleteTantangan = async id => {
	const { data } = await api.delete(`/resleting/tantangan/${id}`);

  return data;
}