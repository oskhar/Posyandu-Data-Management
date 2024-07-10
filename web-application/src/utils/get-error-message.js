import { isAxiosError } from 'axios';
import z from 'zod';

export const UNAUTHED_PAGE_VISIT_MESSAGE =
	'Anda tidak memiliki akses ke halaman ini, silahkan login ulang.';
export const DEFAULT_ERROR_MESSAGE = 'Terjadi kesalahan, silahkan coba lagi';

export function getErrorMessage(err, defaultMesssage = DEFAULT_ERROR_MESSAGE) {
	if (isAxiosError(err)) {
		const errResponse = err.response?.data;

		if (isErrorApiResponse(errResponse)) {
			if (errResponse.errors.message) {
				return errResponse.errors.message;
			}

			if ('message' in errResponse && errResponse.message) {
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