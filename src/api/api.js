import request from '@/utils/request'
export function getAllGrades (token, sid, ar) {
  return request({
    url: '/admin/getallgrade',
    method: 'post',
    data: { token: token, sid: sid, target: ar }
  })
}
export function getUserInfo (token, sid) {
  return request({
    url: '/user/getinfo',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function getStuGrades (token, sid) {
  return request({
    url: '/stu/getgrade',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function getAllStudents (token, sid, ar) {
  return request({
    url: '/admin/getallstudent',
    method: 'post',
    data: { token: token, sid: sid, target: ar }
  })
}
export function getAllCourses (token, sid) {
  return request({
    url: '/admin/getallcourse',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function getAllTeachers (token, sid) {
  return request({
    url: '/admin/getallteacher',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function getMyGrades (token, sid) {
  return request({
    url: '/stu/getgrade',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function login (token, sid) {
  return request({
    url: '/user/login',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function logout (token, sid) {
  return request({
    url: '/user/logout',
    method: 'post',
    data: { token: token, sid: sid }

  })
}
export function getAllClass (token, sid) {
  return request({
    url: '/admin/getallclass',
    method: 'post',
    data: { token: token, sid: sid }

  })
}
export function postReq (token, sid) {
  return request({
    url: '/act/acts',
    method: 'post',
    data: { token: token, sid: sid }
  })
}
export function addCourse (token, sid, ar) {
  return request({
    url: '/admin/addcourse',
    method: 'post',
    data: { token: token, sid: sid, target: ar }
  })

}
export function delCourse (token, sid, ar) {
  return request({
    url: '/admin/delcourse',
    method: 'post',
    data: { token: token, sid: sid, target: ar }
  })

}
export function editCourse (token, sid, ar, repr) {
  return request({
    url: '/admin/editcourse',
    method: 'post',
    data: { token: token, sid: sid, target: ar, repr: repr }
  })

}
export function addStudent (token, sid, ar, t) {
  return request({
    url: '/admin/addstudent',
    method: 'post',
    data: { token: token, sid: sid, target: ar, classid: t }
  })

}
export function delStudent (token, sid, ar, id) {
  return request({
    url: '/admin/delstudent',
    method: 'post',
    data: { token: token, sid: sid, target: ar, classid: id }
  })

}
export function editStudent (token, sid, ar, repr) {
  return request({
    url: '/admin/editstudent',
    method: 'post',
    data: { token: token, sid: sid, target: ar, repr: repr }
  })

}
export function addGrade (token, sid, ar, id) {
  return request({
    url: '/admin/addgrade',
    method: 'post',
    data: { token: token, sid: sid, target: ar, stuid: id }
  })

}
export function delGrade (token, sid, ar, id) {
  return request({
    url: '/admin/delgrade',
    method: 'post',
    data: { token: token, sid: sid, target: ar, stuid: id }
  })

}
export function editGrade (token, sid, ar, repr) {
  return request({
    url: '/admin/editgrade',
    method: 'post',
    data: { token: token, sid: sid, target: ar, repr: repr }
  })

}

