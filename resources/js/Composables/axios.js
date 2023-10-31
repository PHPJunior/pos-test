import axios from "axios";

export function useAxios(token) {
    const axiosInstance = axios.create({
        headers: {
            'Authorization': 'Bearer ' + token
        }
    })

    return {
        axiosInstance
    }
}
