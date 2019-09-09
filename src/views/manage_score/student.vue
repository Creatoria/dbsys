<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="2">
        <el-button
          type="primary"
          icon="el-icon-back"
          style="width:100%"
          @click="back"
        />
      </el-col>
      <el-col :span="6">
        <el-input
          v-model="searchField.coursename"
          placeholder="请输入课程以搜索"
          clearable=""
        />
      </el-col>
      <el-col :span="2">
        <el-button
          icon="el-icon-circle-plus-outline"
          @click="addDialogVisible=true"
        >添加</el-button>
      </el-col>
      <el-col :span="2">
        <el-button
          icon="el-icon-refresh"
          type="primary"
          @click="fetchData"
        />
      </el-col>

    </el-row>
    <el-row>
      <el-table
        v-loading="listLoading"
        :data="filtedData"
        element-loading-text="Loading"
        border
        fit
        highlight-current-row
      >
        <el-table-column label="课程">
          <template slot-scope="scope">{{ scope.row.courseid }}</template>
        </el-table-column>
        <el-table-column label="成绩">
          <template slot-scope="scope"><span :class="isred(scope.row.grade)">{{ scope.row.grade }}</span></template>
        </el-table-column>
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button
              icon="el-icon-edit"
              @click="edit(scope.row)"
            >编辑</el-button>
            <el-button
              type="danger"
              icon="el-icon-delete"
              @click="confirmDel(scope.row)"
            >删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-dialog
      title="提示"
      :visible.sync="deleDialogVisible"
      width="30%"
    >
      <span>确认要删除吗</span>
      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="deleDialogVisible = false">取 消</el-button>
        <el-button
          type="danger"
          @click="del"
        >确 定</el-button>
      </span>
    </el-dialog>

    <el-dialog
      title="编辑"
      :visible.sync="editDialogVisible"
    >
      <el-form>
        <el-row>
          <el-form-item label="课程">
            <el-input
              v-model="tmp.courseid"
              disabled=""
            />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="成绩">
            <el-input
              v-model="tmp.grade"
              clearable=""
            />
          </el-form-item>
        </el-row>
      </el-form>
      <div
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="editDialogVisible = false">取 消</el-button>
        <el-button
          type="primary"
          @click="confirmEdit"
        >确 定</el-button>
      </div>
    </el-dialog>
    <el-dialog
      :visible.sync="succDialogVisibe"
      title="提示"
    >
      <span>操作成功</span>
      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button
          type="primary"
          @click="succDialogVisibe = false"
        >确 定</el-button>
      </span>
    </el-dialog>
    <el-dialog
      :visible.sync="addDialogVisible"
      title="添加"
    >
      <el-form>
        <el-row>
          <el-form-item label="课程">
            <el-input v-model="tmp.courseid" />
          </el-form-item>
        </el-row>
        <el-row>
          <el-form-item label="成绩">
            <el-input v-model="tmp.grade" />
          </el-form-item>
        </el-row>
      </el-form>
      <div
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="addDialogVisible = false">取 消</el-button>
        <el-button
          type="primary"
          @click="confirmAdd"
        >确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import { getAllGrades, addGrade, editGrade, delGrade } from '@/api/api'
import { mapGetters } from 'vuex'
import { MessageBox, Message } from 'element-ui'

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
        courseid: '',
        coursename: '',
        year: '',
        grade: ''
      },
      editing: 0,
      searchField: {
        coursename: '',
        year: ''
      },
      filter: {}
    }
  },
  computed: {
    filtedData() {
      return this.list
        .filter(item => {
          var reg = new RegExp(this.searchField.coursename, 'i')
          return !this.searchField.coursename || reg.test(item.coursename)
        })
        .filter(item => {
          var reg = new RegExp(this.searchField.year, 'i')
          return !this.searchField.year || reg.test(item.year)
        })
    }
  },
  created() {
    if (this.$store.getters.role.indexOf('admin') >= 0) {
      this.fetchData(this.$route.query.stuid)
    } else {
      MessageBox.confirm('没有权限访问此页面', {
        type: 'warning',
        showClose: false,
        showCancelButton: false
      }).then(() => {
        this.$router.go(-1)
      })
    }
  },
  methods: {
    isred: function(e) {
      return { red: e < 60 }
    },

    fetchData(e) {
      this.listLoading = true
      getAllGrades(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.$route.query.stuid
      ).then(response => {
        console.log(response)
        this.list = response.items
        this.listLoading = false
      })
    },
    confirmDel(e) {
      this.deleDialogVisible = true
      this.editing = e
    },
    del() {
      delGrade(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.editing,
        this.$route.query.stuid
      ).then(_ => {
        if (_.code === 20000) {
          this.$alert('操作成功').then(() => {
            this.fetchData(this.$route.query.stuid)
          })
        }
      })
    },
    edit(e) {
      this.tmp = JSON.parse(JSON.stringify(e))
      this.editing = e
      this.editDialogVisible = true
    },
    confirmEdit(g) {
      editGrade(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.editing,
        this.tmp
      ).then(e => {
        this.$alert('操作成功').then(() => {
          this.editDialogVisible = false
          this.fetchData(this.$route.query.stuid)
          this.tmp = {}
        })
      })
    },
    confirmAdd() {
      addGrade(
        this.$store.getters.token,
        this.$store.getters.sid,
        this.tmp,
        this.$route.query.stuid
      ).then(_ => {
        this.$alert('操作成功').then(() => {
          this.addDialogVisible = false
          this.fetchData(this.$route.query.stuid)
          this.tmp = {}
        })
      })
    },
    go() {
      this.$router.push({ path: '/grades/acad' })
    },
    back() {
      this.$router.go(-1)
    }
  }
}
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
