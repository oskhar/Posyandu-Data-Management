import { isAxiosError } from 'axios';
import z from 'zod';

export const DEFAULT_ERROR_MESSAGE = 'Terjadi kesalahan, silahkan coba lagi';

export function getErrorMessage(err, defaultMesssage = DEFAULT_ERROR_MESSAGE) {
	if (isAxiosError(err)) {
		const errResponse = err.response?.data;
		
		if (isErrorApiResponse(errResponse)) {
			return flattenApiErrorResponse(errResponse.errors)
		}

		return err.message;
	}

	if (err instanceof z.ZodError) {
		return flattenZodError(err);
	}


	if (err instanceof Error) {
		return err.message;
	}

	return defaultMesssage;
}

export function getSwalErrorMessage(err, defaultMesssage = DEFAULT_ERROR_MESSAGE) {
	return `<pre>${getErrorMessage(err, defaultMesssage)}</pre>`;
}

export function isErrorApiResponse(response) {
	if (typeof response !== 'object' || response === null) {
		return false;
	}

	return 'errors' in response;
}

/**
 * @param {Record<string, string[]>} errors 
 */
export function flattenApiErrorResponse(errors) {
	return Object.entries(errors)
	.map(([_, messages]) => `${messages.join('\n')}`)
	.join('\n');
}

export function flattenZodError(zodError) {
	return zodError.issues.map(issue => issue.message).join('\n');
}