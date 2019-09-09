<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-input v-model="searchField.courseid"
                  placeholder="请输入课程号以搜索"
                  clearable="" />
      </el-col>
      <el-col :span="6">

        <el-input v-model="searchField.name"
                  placeholder="请输入课程名以搜索"
                  clearable="" />
      </el-col>
      <el-col :span="4">

        <el-select v-model="searchField.type"
                   placeholder="请选择课程性质以搜索"
                   clearable=""
                   style="width:100%">
          <el-option value="必修">必修</el-option>
          <el-option value="选修">选修</el-option>
        </el-select>
      </el-col>
      <el-col :span="2">
        <el-button icon="el-icon-circle-plus-outline"
                   @click="addDialogVisible=true">添加</el-button>
      </el-col>
      <el-col :span="2">
        <el-button icon="el-icon-refresh"
                   type="primary"
                   @click="fetchData" />
      </el-col>
    </el-row>
    <el-row>
      <el-table v-loading="listLoading"
                :data="filtedData"
                element-loading-text="Loading"
                border
                fit
                highlight-current-row>
        <el-table-column label="课程号">
          <template slot-scope="scope">{{ scope.row.courseid }}</template>
        </el-table-column>
        <el-table-column label="课程名">
          <template slot-scope="scope">{{ scope.row.name }}</template>
        </el-table-column>
        <el-table-column label="性质">
          <template slot-scope="scope">{{ scope.row.type }}</template>
        </el-table-column>
        <el-table-column label="学分">
          <template slot-scope="scope">{{ scope.row.credit }}</template>
        </el-table-column>

        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button icon="el-icon-edit"
                       @click="edit(scope.row)">编辑</el-button>
            <el-button type="danger"
                       icon="el-icon-delete"
                       @click="confirmDel(scope.row)">删除</el-button>
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
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="课程名">
            <el-input v-model="tmp.name"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="性质">
            <el-select v-model="tmp.type"
                       clearable="">
              <el-option value="必修">必修</el-option>
              <el-option value="选修">选修</el-option>

            </el-select>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="学分">
            <el-input v-model="tmp.credit"
                      clearable="" />
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
    <el-dialog :visible.sync="addDialogVisible"
               title="添加">
      <el-form>
        <el-row>
          <el-form-item label="课程号">
            <el-input v-model="tmp.courseid"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="课程名">
            <el-input v-model="tmp.name"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="性质">
            <el-select v-model="tmp.type"
                       clearable="">
              <el-option value="必修">必修</el-option>
              <el-option value="选修">选修</el-option>
            </el-select>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="学分">
            <el-input v-model="tmp.credit"
                      clearable="" />
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
import { getAllCourses, addCourse, editCourse, delCourse } from "@/api/api";
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
        name: "",
        type: "",
        credit: ""
      },
      editing: {},
      searchField: {
        courseid: "",
        name: "",
        type: "",
        credit: ""
      },
      filter: {}
    };
  },
  computed: {
    filtedData() {
      return this.list
        .filter(item => {
          var reg = new RegExp(this.searchField.courseid, "i");
          return !this.searchField.courseid || reg.test(item.courseid);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.name, "i");
          return !this.searchField.name || reg.test(item.name);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.type, "i");
          return !this.searchField.type || reg.test(item.type);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.class, "i");
          return !this.searchField.class || reg.test(item.class);
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
      getAllCourses(this.$store.getters.token, this.$store.getters.sid).then(
        response => {
          this.list = response.items;
          this.listLoading = false;
        }
      );
    },
    confirmDel(e) {
      this.deleDialogVisible = true;
      this.editing = e;
    },
    del() {
      delCourse(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.editing
      ).then(_ => {
        this.deleDialogVisible = false;
        if (_.code === 20000) {
          this.$alert("操作成功").then(() => {
            this.fetchData();
          });
        }
      });
    },
    edit(e) {
      this.tmp = JSON.parse(JSON.stringify(e));
      this.editing = e;
      this.editDialogVisible = true;
    },
    confirmEdit(g) {
      editCourse(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.editing,
        this.tmp
      ).then(e => {
        if (e.code == 20000) {
          this.editDialogVisible = false;
          this.$alert("操作成功").then(() => {
            this.fetchData();
          });
        }
      });
    },
    confirmAdd() {
      addCourse(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.tmp
      ).then(e => {
        this.tmp = {
          courseid: "",
          name: "",
          type: "",
          credit: ""
        };
        if (e.code == 20000) {
          this.addDialogVisible = false;
          this.$alert("操作成功").then(() => {
            this.fetchData();
          });
        }
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
</style>
