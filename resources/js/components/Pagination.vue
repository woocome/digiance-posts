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
      const totalPages = this.totalPages;
      const currentPage = this.currentPage;
      const range = 3; // Adjust the range to control how many pages are shown around the current page
      
      // Always show the first page
      pagesArray.push(1);

      // Add ellipsis if the current page is far from the first page
      if (currentPage > range + 2) {
        pagesArray.push('...');
      }

      // Calculate the range of pages around the current page
      const startPage = Math.max(2, currentPage - range);
      const endPage = Math.min(totalPages - 1, currentPage + range);

      // Add pages around the current page
      for (let i = startPage; i <= endPage; i++) {
        pagesArray.push(i);
      }

      // Add ellipsis if the current page is far from the last page
      if (currentPage < totalPages - range - 1) {
        pagesArray.push('...');
      }

      // Always show the last page if it’s greater than 1
      if (totalPages > 1) {
        pagesArray.push(totalPages);
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