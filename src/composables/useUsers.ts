import { reactive, ref } from 'vue';

import API from '@/api';

import { User } from '@/components/types/User';

const state = reactive<User[]>([]);
const isFetching = ref<boolean>(false);
const page = reactive<number>(1);

export const useUsers = () => {
  const fetchUsers = () => {
    isFetching = true;

    API.get<User[]>(`/users/list&page=${page}`).then((data) => {
      state = data;
      isFetching = false;
    });
  };

  const search = async (search: string) => {
    isFetching = true;
    state = await API.get(`/users/list&search=${search}`)
    isFetching = false;
  }

  const fetchMoreUsers = () => {
    page += 1;
    fetchUsers();
  };

  const setPage = (newPage: number) => {
    page = newPage;
  };

  return {
    fetchUsers,
    fetchMoreUsers,
    search,
    setPage,
    isFetching,
    usersList: state
  };
};
