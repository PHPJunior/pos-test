import { ref, onMounted } from 'vue'
import { useAxios } from "@/Composables/axios.js";

export function useData({ url, token, perPage = 10, relations = [], defaultOrderBy = [] }) {
    const { axiosInstance } = useAxios(token)

    const fetchedData = ref([])
    const total = ref(0)
    const lastPage = ref(0)
    const currentPage = ref(0)
    const nextPageDisabled = ref(false)
    const prevPageDisabled = ref(false)
    const orderBy = ref([...defaultOrderBy])

    const getData = async () => {
        const { data } = await axiosInstance.get(url, {
            params: {
                page: currentPage.value,
                per_page: perPage,
                relations: [...relations],
                order_by: [...orderBy.value]
            }
        })

        fetchedData.value = data.data
        total.value = data.meta.total
        lastPage.value = data.meta.last_page
        currentPage.value = data.meta.current_page
        nextPageDisabled.value = data.links.next == null
        prevPageDisabled.value = data.links.prev == null
    }

    const fetchNext = () => {
        if (!nextPageDisabled.value) {
            currentPage.value++
            getData()
        }
    }

    const fetchPrev = () => {
        if (!prevPageDisabled.value) {
            currentPage.value--
            getData()
        }
    }

    const deleteData = async (deleteUrl) => {
        axiosInstance.delete(deleteUrl).then(() => {
            currentPage.value = 1
        }).finally(() => {
            getData()
        })
    }

    const reloadData = () => {
        currentPage.value = 1
        getData()
    }

    const updateDirection = (column) => {
        const index = orderBy.value.findIndex((item) => item.column === column);
        if (index === -1) {
            orderBy.value.push({
                column,
                direction: 'asc',
            });
        } else {
            orderBy.value[index].direction = orderBy.value[index].direction === 'asc' ? 'desc' : 'asc';
        }

        reloadData();
    }

    const getDirection = (column) => {
        const index = orderBy.value.findIndex((item) => item.column === column);

        if (index === -1) {
            return null;
        }

        return orderBy.value[index].direction;
    }

    onMounted(() => getData());

    return {
        fetchedData,
        perPage,
        total,
        lastPage,
        currentPage,
        nextPageDisabled,
        prevPageDisabled,
        fetchNext,
        fetchPrev,
        getData,
        deleteData,
        reloadData,
        updateDirection,
        getDirection,
    }
}
