import { isAxiosError } from 'axios';
import z from 'zod';

export const UNAUTHED_PAGE_VISIT_MESSAGE =
	'Anda tidak memiliki akses ke halaman ini, silahkan login ulang.';
export const DEFAULT_ERROR_MESSAGE = 'Terjadi kesalahan, silahkan coba lagi';

export function getErrorMessage(err, defaultMesssage = DEFAULT_ERROR_MESSAGE) {
	if (isAxiosError(err)) {
		const errResponse = err.response?.data;
		
		if (isErrorApiResponse(errResponse)) {
			if (typeof errResponse.errors === "object") {
				return flattenApiErrorResponse(errResponse.errors)
			}

			if (errResponse.message) {
				return errResponse.message;
			}

			return err.message;
		}

		return err.message;
	}

	if (err instanceof z.ZodError) {
		const errors = err.issues.map(issue => issue.message);

		return errors.join('\n');
	}


	if (err instanceof Error) {
		return err.message;
	}

	return defaultMesssage;
}

export function isErrorApiResponse(
	response,
){
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