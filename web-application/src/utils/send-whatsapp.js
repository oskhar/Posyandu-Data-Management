export function getWhatsappLink(phone, message) {
	return `https://wa.me/${phone}?text=${encodeURI(message)}`;
}

export function sendWhatsapp(phone, message) {
	const link = getWhatsappLink(phone, message);

	window.open(link, '_blank');
}