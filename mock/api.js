import Mock from 'mockjs'
const studentsData = Mock.mock({
  'items|30': [{
    stuid: "@id",
    name: '@cname',
    "sex|1": ["男", "女"],
    class: '@word',

  }]
})
const gradesData = Mock.mock({
  'items|30': [{
    courseid: '@id',
    stuid: "@id",
    coursename: '@word',
    studentname: '@cname',
    "year|2008-2018": 2008,
    'grade|1-100': 100
  }]
})
const teachersData = Mock.mock({
  'items|30': [{
    teacherid: "@id",
    name: '@cname',
    "sex|1": ["男", "女"],
    acad: '@word',
  }]
})
const coursesData = Mock.mock({
  'items|30': [{
    courseid: "@id",
    name: '@word',
    "type|1": ['必修', "选修"],
    credit: "@float(0.5,5,0,1)"

  }]
})
const classesData = Mock.mock({
  "items|50": [{
    acad: '@word(1)',
    major: '@word(1)',
    class: "@word(2)",
    classid: "@id"

  }]
})
export default [
  {
    url: '/admin/getallgrades',
    type: 'post',
    response: config => {
      const items = gradesData.items
      return {
        code: 20000,
        data: {
          total: items.length,
          items: items
        }
      }
    }
  }, {
    url: '/act/acts',
    type: 'post',
    response: config => {
      console.log(config.body)
      return {
        code: 20000,
      }
    }
  }, {
    url: '/admin/getallstudents',
    type: 'post',
    response: config => {
      const items = studentsData.items
      return {
        code: 20000,
        data: {
          total: items.length,
          items: items
        }
      }
    }
  }, {
    url: '/admin/getallteachers',
    type: 'post',
    response: config => {
      const items = teachersData.items
      return {
        code: 20000,
        data: {
          total: items.length,
          items: items
        }
      }
    }
  }, {
    url: '/admin/getallcourses',
    type: 'post',
    response: config => {
      const items = coursesData.items
      return {
        code: 20000,
        data: {
          total: items.length,
          items: items
        }
      }
    }
  }, {
    url: '/admin/getallclass',
    type: 'post',
    response: config => {
      const items = classesData.items
      return {
        code: 20000,
        data: {
          total: items.length,
          items: items
        }
      }
    }
  },
  {
    url: '/stu/getgrade',
    type: 'post',
    response: config => {
      const items = gradesData.items
      return {
        code: 20000,
        data: {
          total: items.length,
          items: items,
        },
      }
    }
  }
]
