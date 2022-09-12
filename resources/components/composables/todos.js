import { ref } from 'vue'
import axios from "axios";
import { useRouter } from 'vue-router';

export default function toDoComposables () {
    const router = useRouter()
    const errors = ref('')
    const todos = ref([])
    const todo = ref([])
    const tasks = ref([])

    const getToDos = async () => {
        let response = await axios.get('/api/todos/index')
        todos.value = response.data.data
    }

    const getToDo = async (id) => {
        let response = await axios.get(`/api/todos/new/${id}`)
        todo.value = response.data.data;
    }

    const getTasks = async () => {
        let response = await axios.get(`/api/tasks/index`)
        tasks.value = response.data.data;
    }

    const storeToDo = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/todos/store', data)
            await router.push({name: 'todo_index'})
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

    // const insertToDo = async (data) => {
    //     errors.value = ''
    //     try {
    //         await axios.post('/api/todos/insert', data)
    //         await router.push({name: 'todo_index'})
    //     } catch (e) {
    //         if (e.response.status === 422) {
    //             errors.value = e.response.data.errors
    //         }
    //     }
    // }

    const updateToDo = async (id) => {
        errors.value = ''
        try {
            await axios.put('/api/todos/update/' + id, todo.value)
            await router.push({name: 'todos_index'})
        } catch (e) {
            if (e.response.status === 422) {
               errors.value = e.response.data.errors
            }
        }
    }

    const deleteToDo = async (id) => {
        await axios.delete('/api/companies/' + id)
    }


    return {
        errors,
        getToDos,
        getToDo,
        todos,
        todo,
        getTasks,
        tasks,
        
        storeToDo,
        // insertToDo,

        updateToDo,
        deleteToDo
    }
}