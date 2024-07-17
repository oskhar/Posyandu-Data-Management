
export const getSubmissions = async ({
  tantanganId,
  search,
  page = 1,
  lengthPerPage = 6,
}) => {
	// TODO: implement getSubmissions
	return {
    links: new Array(10).fill(""),
    current_page: page,
    data: Array.from({ length: lengthPerPage }, (_, id) => (
      {
        id,
        tantangan_id: 101,
        file: id % 2 ? null : "data:application/pdf;base64,JVBERi0xLjcKCjEgMCBvYmoKPDwvVHlwZS9DYXRhbG9nL1BhZ2VzIDIgMCBSL0xhbm... (truncated base64 data)",
        link: id % 3 ? null : "https://example.com/file.pdf",
        status: "active",
      }
    )),
  }
}

export const createFeedback = async (submissionId, { feedback, peringkat }) => {
  // TODO: implement createFeedback
  console.log(submissionId, { feedback, peringkat });

  return {
    message: "Feedback berhasil dibuat",
  }
}

export const editFeedback = async feedback => {
  // TODO: implement editFeedback
}