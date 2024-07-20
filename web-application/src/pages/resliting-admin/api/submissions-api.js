import { api } from "@/lib/api";

export const getSubmissions = async ({
  tantanganId,
  search,
  page = 1,
  lengthPerPage = 6,
}) => {
  const { data } = await api.get("/resleting/submission", {
    params: { search, length: lengthPerPage, page, tantangan_id: tantanganId },
  })


  return data;  
}

export const editFeedback = async (submissionId, feedback) => {
  const { data } = await api.put(`/resleting/submission/${submissionId}`, feedback)

  return data; 
}