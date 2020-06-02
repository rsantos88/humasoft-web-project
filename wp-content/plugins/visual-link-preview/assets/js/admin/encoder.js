import base64 from 'base-64';
import utf8 from 'utf8';

export const encodeLink = function(link) {
	return base64.encode(utf8.encode(JSON.stringify(link)));
}

export const decodeLink = function(encoded) {
	let decoded = '';
	try {
		decoded = JSON.parse(utf8.decode(base64.decode(encoded)));
	} catch (e) {
		decoded = JSON.parse(base64.decode(encoded));
	}
	return decoded;
}