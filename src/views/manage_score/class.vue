<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="2">
        <el-button type="primary"
                   icon="el-icon-back"
                   style="width:100%"
                   @click="back" />
      </el-col>

      <el-col :span="5">
        <el-input v-model="searchField.studentname"
                  placeholder="请输入姓名以搜索"
                  clearable="" />
      </el-col>
      <el-col :span="4">

        <el-select v-model="searchField.sex"
                   placeholder="请选择性别以搜索"
                   clearable=""
                   style="width:100%">
          <el-option value="男">男</el-option>
          <el-option value="女">女</el-option>
        </el-select>
      </el-col>
      <el-col :span="6">

        <el-input v-model="searchField.stuid"
                  placeholder="请输入学号以搜索"
                  clearable="" />
      </el-col>
      <el-col :span="2">
        <el-button icon="el-icon-circle-plus-outline"
                   @click="addDialogVisible=true">添加</el-button>
      </el-col>
      <el-col :span="2">
        <el-button icon="el-icon-refresh"
                   type="primary"
                   @click="refetch" />
      </el-col>

    </el-row>
    <el-row>
      <el-table v-loading="listLoading"
                :data="filtedData"
                element-loading-text="Loading"
                border
                fit
                highlight-current-row>
        <el-table-column label="学号">
          <template slot-scope="scope">{{ scope.row.stuid }}</template>
        </el-table-column>
        <el-table-column label="姓名">
          <template slot-scope="scope">{{ scope.row.name }}</template>
        </el-table-column>
        <el-table-column label="性别">
          <template slot-scope="scope">{{ scope.row.sex }}</template>
        </el-table-column>

        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button icon="el-icon-view"
                       @click="go(scope.row.stuid)">查看</el-button>
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
          <el-form-item label="学号">
            <el-input v-model="tmp.stuid"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="姓名">
            <el-input v-model="tmp.name"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="性别">
            <el-select v-model="tmp.sex"
                       clearable=""
                       placeholder="请选择性别">
              <el-option value="男">男</el-option>
              <el-option value="女">女</el-option>

            </el-select>
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
          <el-form-item label="学号">
            <el-input v-model="tmp.stuid"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="姓名">
            <el-input v-model="tmp.name"
                      clearable="" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="性别">
            <el-select v-model="tmp.sex"
                       clearable=""
                       placeholder="请选择性别">
              <el-option value="男">男</el-option>
              <el-option value="女">女</el-option>

            </el-select>
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
import { getAllStudents, addStudent, editStudent, delStudent } from "@/api/api";
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
        stuid: "",
        name: "",
        sex: ""
      },
      editing: 0,
      searchField: {
        name: "",
        stuid: "",
        sex: ""
      },
      filter: {}
    };
  },
  computed: {
    filtedData() {
      return this.list
        .filter(item => {
          var reg = new RegExp(this.searchField.studentname, "i");
          return !this.searchField.studentname || reg.test(item.studentname);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.sex, "i");
          return !this.searchField.sex || reg.test(item.sex);
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.stuid, "i");
          return !this.searchField.stuid || reg.test(item.stuid);
        });
    }
  },
  created() {
    if (this.$store.getters.role.indexOf("admin") >= 0) {
      this.fetchData(this.$route.query.classid);
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
    fetchData(e) {
      this.listLoading = true;
      getAllStudents(
        this.$store.getters.token,
        this.$store.getters.sid,
        e
      ).then(response => {
        this.list = response.items;
        this.listLoading = false;
      });
    },
    refetch() {
      this.fetchData(this.$route.query.classid);
    },
    confirmDel(e) {
      this.deleDialogVisible = true;
      this.editing = e;
    },
    del() {
      delStudent(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.editing,
        this.$route.query.classid
      ).then(_ => {
        if (_.code === 20000) {
          this.$alert("操作成功").then(() => {
            this.fetchData(this.$route.query.classid);
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
      editStudent(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.editing,
        this.tmp
      ).then(e => {
        this.$alert("操作成功").then(() => {
          this.editDialogVisible = false;
          this.fetchData(this.$route.query.classid);
          this.tmp = {
            stuid: "",
            name: ""
          };
        });
      });
    },
    confirmAdd() {
      addStudent(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.tmp,
        this.$route.query.classid
      ).then(_ => {
        this.$alert("操作成功").then(() => {
          this.addDialogVisible = false;
          this.fetchData(this.$route.query.classid);
          this.tmp = {
            stuid: "",
            name: ""
          };
        });
      });
    },
    go(e) {
      var dir = "/grades/student?stuid=" + e;
      this.$router.push({ path: dir });
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
</style>
