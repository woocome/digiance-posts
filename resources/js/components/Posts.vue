<template>
  <div>
    <div class="search-bar mb-3">
      <input
        type="text"
        v-model="searchQuery"
        @input="onSearch"
        placeholder="Search by title"
        class="form-control"
      />
    </div>

    <div class="row g-3">
      <div v-for="post in posts" :key="post.id" class="col-12 col-sm-6 col-lg-4" v-if="posts.length">
        <div class="card p-2 h-100">
          <h2>{{ post.title }}</h2>
          <p>{{ post.body }}</p>
        </div>
      </div>
      <div v-else>
        No post found.
      </div>
    </div>

    <Pagination
      class="mt-4"
      :total-pages="meta?.last_page"
      :total-items="meta?.total"
      :per-page="meta?.per_page"
      :current-page="currentPage"
      @page-changed="fetchPosts"
    />
  </div>
</template>

<script>
import axios from 'axios';
import { fnApi } from '@/utils/api'; // Adjust the path as necessary

export default {
  data() {
    return {
      posts: [],
      totalPages: 1,
      currentPage: 1,
      totalItems: 0,
      meta: [],
      searchQuery: '',
      abortController: null,
      loading: true
    };
  },
  mounted() {
    this.fetchPosts(this.currentPage);
  },
  methods: {
    async fetchPosts(page) {
      page = page ?? this.currentPage

      if (this.abortController) {
        this.abortController.abort();
      }

      try {

        this.abortController = new AbortController();
        const signal = this.abortController.signal;

        this.loading = true;

        const response = await fnApi.call(`/posts?page=${page}`, 'GET', {search: this.searchQuery}, signal);
        this.posts = response.data;
        this.meta = response.meta
        this.currentPage = this.meta.current_page;

      } catch (error) {
        if (error.name === 'AbortError') {
          // console.log('Previous search request was cancelled.');
        } else {
          // console.error('Error fetching posts:', error);
        }
      } finally {
        this.loading = false;
      }
    },
    onSearch() {
      this.currentPage = 1;

      this.fetchPosts();
    }
  },
};
</script>

<style scoped>
.post {
  margin-bottom: 20px;
}
</style>
