<template>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <li class="page-item" :class="{ disabled: currentPage === 1 }">
        <a class="page-link" @click="changePage(currentPage - 1)" aria-label="Previous">
          Previous
        </a>
      </li>

      <li v-for="page in pages" :key="page" class="page-item" :class="{ active: page === currentPage }">
        <a class="page-link" @click="changePage(page)">{{ page }}</a>
      </li>

      <li class="page-item" :class="{ disabled: currentPage === totalPages }">
        <a class="page-link" @click="changePage(currentPage + 1)" aria-label="Next">
          Next
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true,
    },
    totalItems: {
      type: Number,
      required: true,
    },
    pageSize: {
      type: Number,
      default: 12,
    },
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalItems / this.pageSize);
    },
    pages() {
      const pagesArray = [];
      const range = 6;

      for (let i = Math.max(1, this.currentPage - range); i <= Math.min(this.totalPages, this.currentPage + range); i++) {
        pagesArray.push(i);
      }

      if (this.currentPage > range) {
        pagesArray.unshift('...');
      }

      if (this.totalPages > this.currentPage + range) {
        pagesArray.push('...');
      }

      return pagesArray;
    },
  },
  methods: {
    changePage(page) {
      if (page < 1 || page > this.totalPages || page === '...') return;
      this.$emit('page-changed', page);
    },
  },
};
</script>


<style scoped>
.pagination {
  display: flex;
  justify-content: center;
}
.page-item.disabled .page-link {
  pointer-events: none;
  opacity: 0.5;
}
.page-item .page-link {
  cursor: pointer;
}
.page-item.active .page-link {
  font-weight: bold;
  cursor: pointer;
}
</style>