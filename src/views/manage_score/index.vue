<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="6">

        <el-input v-model="searchField.acad"
                  placeholder="请输入学院以搜索"
                  clearable="" />
      </el-col>
      <el-col :span="6">
        <el-input v-model="searchField.major"
                  placeholder="请输入专业以搜索"
                  clearable="" />
      </el-col>
      <el-col :span="2">
        <el-button icon="el-icon-refresh"
                   type="primary"
                   @click="fetchData" />
      </el-col>
    </el-row>
    <el-table v-loading="listLoading"
              :data="filtedData"
              element-loading-text="Loading"
              border
              fit
              highlight-current-row>
      <el-table-column align="center"
                       label="班级">
        <template slot-scope="scope">
          {{ scope.row.class }}
        </template>
      </el-table-column>
      <el-table-column align="center"
                       label="专业">
        <template slot-scope="scope">
          {{ scope.row.major }}
        </template>
      </el-table-column>
      <el-table-column align="center"
                       label="学院">
        <template slot-scope="scope">
          {{ scope.row.acad }}
        </template>
      </el-table-column>
      <el-table-column><template slot-scope="scope">
          <el-button @click="go(scope.row.classid)">查看学生</el-button>
        </template></el-table-column>
    </el-table>
  </div>
</template>

<script>
import { getAllClass } from "@/api/api";
import { mapGetters } from "vuex";
import { MessageBox, Message } from "element-ui";
export default {
  data() {
    return {
      list: null,
      listLoading: false,
      searchField: {
        major: "",
        acad: ""
      }
    };
  },
  computed: {
    filtedData() {
      return this.list
        .filter(item => {
          var reg = new RegExp(this.searchField.acad, "i");
          return !this.searchField.acad || reg.test(item.acad);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.major, "i");
          return !this.searchField.major || reg.test(item.major);
        });
    }
  },
  created() {
    if (this.$store.getters.role.indexOf("admin") >= 0) {
      this.fetchData();
    } else {
      MessageBox.confirm("没有权限访问此页面", {
        type: "warning",
        showClose: false,
        showCancelButton: false
      }).then(() => {
        this.$router.go(-1);
      });
    }
  },
  methods: {
    fetchData() {
      this.listLoading = true;
      getAllClass(this.$store.getters.token, this.$store.getters.sid).then(
        response => {
          this.list = response.items;
          this.listLoading = false;
        }
      );
    },
    go(e) {
      var dir = "/grades/class?classid=" + e;
      this.$router.push({ path: dir });
    }
  }
};
</script>

<style>
.el-input,
.el-select {
  width: 100%;
}
.el-row {
  margin-bottom: 20px;
}
.el-col {
  border-radius: 4px;
}
</style>
