<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-input placeholder="请输入课程以搜索"
                  v-model="searchField.coursename"
                  clearable="">

        </el-input>
      </el-col>
      <el-col :span="6">
        <el-input placeholder="请输入年份以搜索"
                  v-model="searchField.year"
                  clearable="">

        </el-input>
      </el-col>
      <el-col :span="2">
        <el-button @click="addDialogVisible=true"
                   icon="el-icon-circle-plus-outline">添加</el-button>
      </el-col>
      <el-col :span="2">
        <el-button icon="el-icon-refresh"
                   type="primary"
                   @click="fetchData"></el-button>
      </el-col>

    </el-row>
    <el-row>
      <el-table :data="filtedData"
                v-loading='listLoading'
                element-loading-text="Loading"
                border
                fit
                highlight-current-row>
        <el-table-column label="课程">
          <template slot-scope="scope">{{scope.row.coursename}}</template>
        </el-table-column>
        <el-table-column label="时间">
          <template slot-scope="scope">{{scope.row.year}}</template>
        </el-table-column>
        <el-table-column label="成绩">
          <template slot-scope="scope"><span :class="isred(scope.row.grade)">{{scope.row.grade}}</span></template>
        </el-table-column>
      </el-table>
    </el-row>

  </div>
</template>
<script>
import { getMyGrades, postReq } from "@/api/api";
import { mapGetters } from "vuex";
import { MessageBox, Message } from "element-ui";

export default {
  data() {
    return {
      list: null,
      listLoading: true,
      searchField: {
        coursename: "",
        year: ""
      },
      filter: {}
    };
  },
  created() {
    if (this.$store.getters.role.indexOf("admin") >= 0) {
      this.$alert("当前为管理员身份，即将重定向到管理页面。").then(() => {
        this.$router.push({ path: "/grades/index" });
      });
    } else if (this.$store.getters.role.indexOf("student") >= 0) {
      this.fetchData(this.$route.query.stuid);
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
  computed: {
    filtedData() {
      return this.list
        .filter(item => {
          var reg = new RegExp(this.searchField.coursename, "i");
          return !this.searchField.coursename || reg.test(item.coursename);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.year, "i");
          return !this.searchField.year || reg.test(item.year);
        });
    }
  },
  methods: {
    isred: function(e) {
      return { red: e < 60 };
    },

    fetchData(e) {
      this.listLoading = true;
      getMyGrades({ stuid: e }).then(response => {
        this.list = response.data.items;
        this.listLoading = false;
      });
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
.red {
  color: red;
}
</style>