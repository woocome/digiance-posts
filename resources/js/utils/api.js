import axios from 'axios';

// Create an Axios instance with default configuration
const createApiClient = (config = {}) => {
  return axios.create({
    baseURL: '/api',
    headers: {
      'Content-Type': 'application/json',
    },
    config,
  });
};

// Function to make API calls
export const fnApi = {
  apiClient: createApiClient(),

  async call(endpoint, method = 'GET', params = {}, signal = null) {
    try {
      // Prepare the request configuration
      const requestConfig = {
        method,
        url: endpoint,
        params: params,
        signal: signal,
      };

      const response = await this.apiClient(requestConfig);
      return response.data
    } catch (error) {
    }
  },
};
