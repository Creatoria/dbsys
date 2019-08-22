import Mock from 'mockjs'
const data = Mock.mock({
    "items|30":[{
        classname:'@word',
        'grade|1-100':100
    }]
})
export default [
    {
      url: '/stu/getgrade',
      type: 'get',
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
    }
  ]
  