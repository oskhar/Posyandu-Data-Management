import { api } from "@/lib/api";
import { getFullImagePath } from "@/utils/get-full-image-path"

export const fetchDataTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	const { data } = await api.get('/resleting/tantangan', {
    params: { page, length: lengthPerPage, search },
  }) 

	/**
	 * @type {import("../../admin-resliting/api/types").TantanganResponse}
	 */
	const dataResponse = data;

  dataResponse.data = dataResponse.data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));

  return dataResponse;
}

export const fetchDataFollowedTantangan = async ({
	page = 1,
	search = "",
	lengthPerPage = 6,
}) => {
	const { data } = await api.get('/user/tantangan', {
    params: { page, length: lengthPerPage, search },
  }) 

	/**
	 * @type {import("../../admin-resliting/api/types").TantanganResponse}
	 */
	const dataResponse = data;

  dataResponse.data = dataResponse.data.map(item => ({ ...item, gambar: getFullImagePath(item.gambar) }));

  return dataResponse;
}

export const fetchDataDetailTantangan = async id => {
	const { data } = await api.get(`/resleting/tantangan/${id}`) 

	/**
	 * @type {import("../../admin-resliting/api/types").Tantangan}
	 */
	const dataResponse = data;

  dataResponse.gambar = getFullImagePath(dataResponse.gambar) 


	return dataResponse
}

export const sendSubmissionTantangan = async ({
	tantangan_id, file = null, link = null, 
}) => {
	const { data }= await api.post('/resleting/submission', {
		tantangan_id, file, link,
	})
	
	return data;
}