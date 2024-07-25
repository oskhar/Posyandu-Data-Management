export function getWhatsappLink(phone, message) {
	return `https://api.whatsapp.com/send/?phone=${phone}&text=${encodeURI(message)}&type=phone_number`;
}

export function sendWhatsapp(phone, message) {
	const link = getWhatsappLink(phone, message);

	window.open(link, '_blank');
}