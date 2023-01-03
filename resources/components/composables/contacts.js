import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';
import { colors } from 'laravel-mix/src/Log';

export default function contactComposables () {
    const contacts = ref([])
    const contact = ref([])
    const users = ref([])
    const statuses = ref([])
    const categories = ref([])
    const types = ref([])
    const router = useRouter()
    const errors = ref('')

    const getContacts = async () => {
        let response = await axios.get('/api/contacts/list')
        contacts.value = response.data.data;
    }

    const getContact = async (id) => {
        let response = await axios.get('/api/contacts/new/' + id)
        contact.value = response.data.data;
    }

    const getStatuses = async () => {
        let response = await axios.get('/api/contacts/status/index')
        statuses.value = response.data.data;
    }

    const getCategories = async () => {
        let response = await axios.get('/api/contacts/category/index')
        categories.value = response.data.data;
    }

    const getTypes = async () => {
        let response = await axios.get('/api/contacts/type/index')
        types.value = response.data.data;
    }

    const getUsers = async () => {
        let response = await axios.get('/api/users/index')
        users.value = response.data.data;
    }

    const storeContact = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/todos/insert', data)
            await router.push({name: 'todo_index'})
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    const updateContact = async (id) => {
        errors.value = ''
        try {
            await axios.put('/api/companies/' + id, company.value)
            await router.push({name: 'companies.index'})
        } catch (e) {
            if (e.response.status === 422) {
               errors.value = e.response.data.errors
            }
        }
    }

    const deleteContact = async (id) => {
        await axios.delete('/api/companies/' + id)
    }


    return {
        getContacts,
        contacts,
        getContact,
        contact,
        getUsers,
        users,
        getStatuses,
        statuses,
        getCategories,
        categories,
        getTypes,
        types,
        errors,     
        storeContact,
        updateContact,
        deleteContact
    }
}