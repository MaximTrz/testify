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

    async request(method, url, data = null) {
        try {
            const response = await axios({
                method,
                url: `${this.baseUrl}${url}`,
                data,
            });
            return response.data;
        } catch (error) {
            throw new Error(error.response?.data?.message || error.message);
        }
    }

    async get(url) {
        return this.request("get", url);
    }

    async post(url, data) {
        return this.request("post", url, data);
    }

    async put(url, data) {
        return this.request("put", url, data);
    }

    async getTest(id) {
        return this.get(`/api/tests/${id}`);
    }

    async postAnswer(data) {
        return this.post("/api/student-anwser", data);
    }

    async putAnswer(data) {
        return this.put("/api/test-results", data);
    }
}
