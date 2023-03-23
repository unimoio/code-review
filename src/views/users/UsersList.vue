<template>
  <div>
    <div class="users-page">
      <h1 class="page-title">Users</h1>
      <div class="users-search">
        <input type="text" v-model="searchQuery">
        <button class="clear-search" @click="searchQuery = ''">X</button>
      </div>
      <ul class="users-list">
        <ContentScroll @load-more="handleLoadMore">
          <UserListItem v-if="!isFetching" v-for="user in usersList" :key="user" @on-user-open="handleUserOpen" @on-user-delete="handleUserDelete" />
          <Loader v-else />
        </ContentScroll>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
  import { ref, watch } from 'vue';
  import { useRouter } from 'vue-router';

  import { useUsers } from '@/composables/useUsers';

  import UserListItem from './UserListItem.vue';
  import ContentScroll from '@/components/ContentScroll.vue';
  import Loader from '@/components/Loader.vue';

  const router = useRouter();
  const {
    fetchUsers,
    fetchMoreUsers,
    usersList,
    isFetching,
    setPage,
    search
  } = useUsers();

  const searchQuery = ref('');

  setPage(1);
  fetchUsers();

  const handleLoadMore = () => {
    if (!isFetching.value) {
      fetchMoreUsers();
    }
  };

  const handleUserOpen = (user: any) => {
    router.push('/user/' + user.id);
  };

  const handleUserDelete = () => {
    usersList.value = usersList.value.filter((user: any) => user.id !== user.id);
  };

  watch(searchQuery, () => {
    if (!!searchQuery.value) {
      search({query: searchQuery.value});
    } else {
      setPage(1);
      fetchUsers();
    }
  }, {immediate: true, deep: true});
</script>

<style lang="scss">
  .page-title {
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 16px;
  }
</style>

<style lang="scss" scoped>
  .users-page {
    padding: 16px;
  }
</style>
