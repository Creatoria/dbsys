<template>
  <div class="app-container">
    <el-button @click="addDialogVisible=true">添加</el-button>
    <el-table :data="list"
              v-loading='listLoading'
              element-loading-text="Loading"
              border
              fit
              highlight-current-row>
      <el-table-column label="课程">
        <template slot-scope="scope">{{scope.row.coursename}}</template>
      </el-table-column>
      <el-table-column label="学号">
        <template slot-scope="scope">{{scope.row.stuid}}</template>
      </el-table-column>
      <el-table-column label="姓名">
        <template slot-scope="scope">{{scope.row.studentname}}</template>
      </el-table-column>
      <el-table-column label="成绩">
        <template slot-scope="scope">{{scope.row.grade}}</template>
      </el-table-column>
      <el-table-column label='操作'>
        <template slot-scope="scope">
          <el-button @click="edit(scope.$index)">编辑</el-button>
          <el-button type="danger"
                     @click="confirmDel(scope.$index)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>

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
                      readonly=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="课程">
            <el-input v-model="tmp.coursename"
                      readonly=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="学号">
            <el-input v-model="tmp.stuid"
                      readonly=""></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="姓名">
            <el-input v-model="tmp.studentname"
                      readonly=""></el-input>
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
            <el-input v-model="tmp.stuid"></el-input>
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="姓名">
            <el-input v-model="tmp.studentname"></el-input>
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
        stuid: "",
        studentname: "",
        grade: ""
      },
      index: 0
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.listLoading = true;
      getAllGrades().then(response => {
        this.list = response.data.items;
        this.listLoading = false;
      });
    },
    confirmDel(e) {
      this.deleDialogVisible = true;
      this.index = e;
    },
    del() {
      // postReq().then(res => {
      this.list.splice(this.index, 1);
      // });
      this.index = 0;
      this.deleDialogVisible = false;

      this.succDialogVisibe = true;
    },
    edit(e) {
      this.index = e;
      this.tmp = JSON.parse(JSON.stringify(this.list[this.index]));
      this.editDialogVisible = true;
    },
    confirmEdit() {
      postReq().then(e => {
        if (e.code == 20000) {
          this.list[this.index].grade = this.tmp.grade;
          this.editDialogVisible = false;
          this.index = 0;
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
    }
  }
};
</script>

<style>
</style>