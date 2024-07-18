export const isAxiosResponse = obj => {
  return (
    obj &&
    typeof obj === 'object' &&
    'data' in obj &&
    'status' in obj &&
    'statusText' in obj &&
    'headers' in obj &&
    'config' in obj &&
    'request' in obj
  );
}


export const getApiResponse = response => {
	if (!response) {
		return null;
	}
	
	if ('success' in response) {
		return response.success;
	}

	if (isAxiosResponse(response)) {
		if ('success' in response.data) {
			return response.data.success;
		}

		return response.data;
	}


	return response
}