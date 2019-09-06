<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="2">
        <el-button type="primary"
                   icon="el-icon-back"
                   @click="back"
                   style="width:100%"></el-button>
      </el-col>
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
        <el-table-column label='操作'>
          <template slot-scope="scope">
            <el-button @click="edit(scope.row)"
                       icon="el-icon-edit">编辑</el-button>
            <el-button type="danger"
                       @click="confirmDel(scope)"
                       icon="el-icon-delete">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-dialog title="提示"
               :visible.sync="deleDialogVisible"
               width="30%">
      <span>确认要删除吗</span>
      <span slot="footer"
            class="dialog-footer">
        <el-button @click="deleDialogVisible = false">取 消</el-button>
        <el-button type="danger"
                   @click="del">确 定</el-button>
      </span>
    </el-dialog>

    <el-dialog title="编辑"
               :visible.sync="editDialogVisible">
      <el-form>
        <el-row>
          <el-form-item label="课程号">
            <el-input v-model="tmp.courseid"
                      disabled=""></el-input>
          </el-form-item>
        </el-row>
        <el-form-item label="年份">
          <el-input v-model="tmp.year"
                    disabled=""></el-input>
        </el-form-item>
        <el-row>
          <el-form-item label="成绩">
            <el-input v-model="tmp.grade"
                      clearable=""></el-input>
          </el-form-item>
        </el-row>
      </el-form>
      <div slot="footer"
           class="dialog-footer">
        <el-button @click="editDialogVisible = false">取 消</el-button>
        <el-button type="primary"
                   @click="confirmEdit">确 定</el-button>
      </div>
    </el-dialog>
    <el-dialog :visible.sync="succDialogVisibe"
               title="提示">
      <span>操作成功</span>
      <span slot="footer"
            class="dialog-footer">
        <el-button type="primary"
                   @click="succDialogVisibe = false">确 定</el-button>
      </span>
    </el-dialog>
    <el-dialog :visible.sync='addDialogVisible'
               title="添加">
      <el-form>
        <el-row>
          <el-form-item label="课程号">
            <el-input v-model="tmp.courseid"></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="课程">
            <el-input v-model="tmp.coursename"></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="学号">
            <el-input v-model="tmp.year"></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="成绩">
            <el-input v-model="tmp.grade"></el-input>
          </el-form-item>
        </el-row>
      </el-form>
      <div slot="footer"
           class="dialog-footer">
        <el-button @click="addDialogVisible = false">取 消</el-button>
        <el-button type="primary"
                   @click="confirmAdd">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import { getAllGrades, postReq } from "@/api/api";
import { mapGetters } from "vuex";
import { MessageBox, Message } from "element-ui";

export default {
  data() {
    return {
      list: null,
      listLoading: true,
      addDialogVisible: false,
      editDialogVisible: false,
      deleDialogVisible: false,
      succDialogVisibe: false,
      tmp: {
        courseid: "",
        coursename: "",
        year: "",
        grade: ""
      },
      editing: 0,
      searchField: {
        coursename: "",
        year: ""
      },
      filter: {}
    };
  },
  created() {
    if (this.$store.getters.role.indexOf("admin") >= 0) {
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
      getAllGrades().then(response => {
        this.list = response.data.items;
        this.listLoading = false;
      });
    },
    confirmDel(e) {
      this.deleDialogVisible = true;
      this.editing = e;
    },
    del() {
      postReq().then(_ => {
        if (_.code === 20000) {
          this.list.splice(this.list.indexOf(this.editing.row), 1);
          this.deleDialogVisible = false;
          this.succDialogVisibe = true;
        }
      });
    },
    edit(e) {
      console.log(e);
      this.tmp = JSON.parse(JSON.stringify(e));
      this.editing = e;
      this.editDialogVisible = true;
    },
    confirmEdit(g) {
      postReq().then(e => {
        if (e.code == 20000) {
          this.editing.grade = this.tmp.grade;
          this.editDialogVisible = false;
          this.tmp = {
            courseid: "",
            coursename: "",
            stuid: "",
            studentname: "",
            grade: ""
          };
          this.succDialogVisibe = true;
        }
      });
    },
    confirmAdd() {
      postReq().then(_ => {
        this.list.unshift(this.tmp);
        this.addDialogVisible = false;
        this.succDialogVisibe = true;
        this.tmp = {
          courseid: "",
          coursename: "",
          stuid: "",
          studentname: "",
          grade: ""
        };
      });
    },
    go() {
      this.$router.push({ path: "/grades/acad" });
    },
    back() {
      this.$router.go(-1);
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