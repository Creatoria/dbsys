import Mock from 'mockjs'
const data = Mock.mock({
  'items|30': [{
    courseid:'@id',
    stuid: "@id",
    coursename: '@word',
    studentname: '@name',
    'grade|1-100': 100
  }]
})
export default [
  {
    url: '/admin/getallgrades',
    type: 'post',
    response: config => {
      const items = data.items
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
    response: _ => {
      return {
        code: 20000
      }
    }
  }
]
