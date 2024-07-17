/**
 * 
 * @param {Blob} blob 
 * @returns {Promise<string>}
 */
export const convertBlobToBase64 = blob => new Promise((resolve, reject) => {
	const reader = new FileReader()

	reader.readAsDataURL(blob)	

	reader.onloadend = () => resolve(reader.result.split(',')[1])
	reader.onerror = reject
})

/**
 * @param {File} file 
 * @returns {boolean}
 */
export const validateFileInput = (file, fileType, fileSize = 10 * 1024 * 1024) => {
	return file && file.type === fileType && file.size <= fileSize
};


/**
 * @param {string} base64 
 */
export const createDownload = base64 => {
	// Mengonversi base64 menjadi blob
	const byteCharacters = atob(base64);
	const byteNumbers = new Array(byteCharacters.length);
	for (let i = 0; i < byteCharacters.length; i++) {
		byteNumbers[i] = byteCharacters.charCodeAt(i);
	}
	const byteArray = new Uint8Array(byteNumbers);
	const blob = new Blob([byteArray], { type: "application/pdf" });

	// Membuat objek Date yang merepresentasikan waktu saat ini
	const currentDate = new Date();

	// Mendapatkan tahun, bulan, tanggal, jam, menit, dan detik
	const year = currentDate.getFullYear();
	const month = currentDate.getMonth() + 1; // Perlu ditambah 1 karena indeks bulan dimulai dari 0
	const day = currentDate.getDate();
	const hours = currentDate.getHours();
	const minutes = currentDate.getMinutes();
	const seconds = currentDate.getSeconds();
	const currentDateTime = `_${year}-${month}-${day}_${hours}:${minutes}:${seconds}`;
	const namaFile = `Surat Tugas - ${currentDateTime}.pdf`;

	// Membuat URL blob dan elemen link untuk mengunduh file
	const url = window.URL.createObjectURL(blob);
	const link = document.createElement("a");

	link.href = url;
	link.setAttribute("download", namaFile);
	document.body.appendChild(link);
	link.click();

	// Membersihkan URL blob dan elemen link
	window.URL.revokeObjectURL(url);
	document.body.removeChild(link);
}

/**
 * @param {string} base64 
 * @returns {string}
 */
export const pdfBase64 = base64 => `data:application/pdf;base64,${base64}`