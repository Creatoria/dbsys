import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/user/login',
    method: 'post',
    data
  })
}

export function getInfo(token, sid) {
  return request({
    url: '/user/getinfo',
    method: 'post',
    data: { token: token, sid: sid }
  })
}

export function logout() {
  return request({
    url: '/user/logout',
    method: 'post'
  })
}
