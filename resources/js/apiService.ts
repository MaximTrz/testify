import axios from "axios";

export default class ApiService {
    baseUrl = "http://127.0.0.1:8000";

    constructor() {
        axios.interceptors.request.use(
            (config) => {
                if (window.authToken) {
                    config.headers.Authorization = `Bearer ${window.authToken}`;
                }
                return config;
            },
            (error) => {
                console.error("Interceptor error:", error);
                return Promise.reject(error);
            },
        );
    }

    async get(url) {
        try {
            const response = await axios.get(`${this.baseUrl}${url}`);
            return response.data;
        } catch (error) {
            throw new Error(error.response.data.message);
        }
    }

    async getTest(id) {
        const response = await this.get(`/api/tests/${id}`);
        return response;
    }
}
