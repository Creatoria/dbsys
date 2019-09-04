<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="6">
        <el-input placeholder="请输入姓名"
                  v-model="searchField.studentname"
                  clearable="">

        </el-input>
      </el-col>
      <el-col :span="6">

        <el-input placeholder="请输入班级"
                  v-model="searchField.class"
                  clearable="">

        </el-input>
      </el-col>
      <el-col :span="4">

        <el-select v-model="searchField.sex"
                   placeholder="请选择性别"
                   clearable=""
                   style="width:100%">
          <el-option value="男">男</el-option>
          <el-option value="女">女</el-option>
        </el-select>
      </el-col>
      <el-col :span="6">

        <el-input placeholder="请输入学号"
                  v-model="searchField.stuid"
                  clearable="">

        </el-input>
      </el-col>
      <el-col :span="2">
        <el-button @click="addDialogVisible=true">添加</el-button>
      </el-col>
    </el-row>
    <el-row>
      <el-table :data="filtedData"
                v-loading='listLoading'
                element-loading-text="Loading"
                border
                fit
                highlight-current-row>
        <el-table-column label="学号">
          <template slot-scope="scope">{{scope.row.stuid}}</template>
        </el-table-column>
        <el-table-column label="姓名">
          <template slot-scope="scope">{{scope.row.name}}</template>
        </el-table-column>
        <el-table-column label="班级">
          <template slot-scope="scope">{{scope.row.class}}</template>
        </el-table-column>
        <el-table-column label="性别">
          <template slot-scope="scope">{{scope.row.sex}}</template>
        </el-table-column>

        <el-table-column label='操作'>
          <template slot-scope="scope">
            <el-button @click="edit(scope.row)">编辑</el-button>
            <el-button type="danger"
                       @click="confirmDel(scope)">删除</el-button>
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
                      clearable=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="姓名">
            <el-input v-model="tmp.name"
                      clearable=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="班级">
            <el-input v-model="tmp.class"
                      clearable=""></el-input>
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
    <el-dialog :visible.sync='addDialogVisible'
               title="添加">
      <el-form>
        <el-row>
          <el-form-item label="学号">
            <el-input v-model="tmp.stuid"
                      clearable=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="姓名">
            <el-input v-model="tmp.name"
                      clearable=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="班级">
            <el-input v-model="tmp.class"
                      clearable=""></el-input>
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
import { getAllStudents, postReq } from "@/api/api";
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
        class: "",
        sex: ""
      },
      editing: 0,
      searchField: {
        name: "",
        stuid: "",
        sex: "",
        class: ""
      },
      filter: {}
    };
  },
  created() {
    this.fetchData();
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
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.class, "i");
          return !this.searchField.class || reg.test(item.class);
        });
    }
  },
  methods: {
    fetchData() {
      this.listLoading = true;
      getAllStudents().then(response => {
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
          this.editing = this.tmp;
          this.editDialogVisible = false;
          this.tmp = {
            stuid: "",
            name: ""
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
          stuid: "",
          name: ""
        };
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