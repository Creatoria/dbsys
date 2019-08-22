<template>
  <div class="app-container">
    <el-table v-loading="listLoading"
              :data="list"
              element-loading-text="Loading"
              border
              fit
              highlight-current-row>
      <el-table-column align="center"
                       label="ID"
                       >
        <template slot-scope="scope">
          {{ scope.row.id }}
        </template>
      </el-table-column>
      <el-table-column label="Name">
        <template slot-scope="scope">
          {{ scope.row.name }}
        </template>
      </el-table-column>
      <el-table-column label="Sex">
        <template slot-scope="scope">
          {{ scope.row.sex }}
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
import { getList } from "@/api/sysdata";

export default {
  //   filters: {
  //     statusFilter(status) {
  //       const statusMap = {
  //         published: 'success',
  //         draft: 'gray',
  //         deleted: 'danger'
  //       }
  //       return statusMap[status]
  //     }
  //   },
  data() {
    return {
      list: null,
      listLoading: true
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.listLoading = true;
      getList().then(response => {
        this.list = response.data.items;
        this.listLoading = false;
      });
    }
  }
};
</script>
