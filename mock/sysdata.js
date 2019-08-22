import Mock from 'mockjs'

const data = Mock.mock({
    'items|30': [{
        id: '@id',
        name: '@first',
        'sex|1': ['male', 'female'],
    }
    ]
})
export default [
    {
      url: '/sysdata/list',
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
  