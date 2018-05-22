var NowDates =
  [
    {spaceNum: 1, year: 2018, month: 5, day: 20, monthNum: 31},
    //今天20号～～～
    //spaceNum关系到日历布局问题，spaceNum = 本月一号的星期数 - 1， 你要算一下
    //year 年份
    //month 月份，此时为5月
    //day 如果用户查看的是1，2，3，4，6，7，8，9，10，11，12，不是5月就这样//day: 32\\
    //monthNum 5月的天数
    {theDayBool:[//theDayBool 按顺序来比如下面有20个布尔值，依次表示第一天老师没有发起签到，。。。。第四天发起了签到，第五天发起了签到。。。。。如果是5月（当前月）现在肯定只有只有20个布尔值（今天二十号）
        true,true,true,false,false,false,false,true,true,false,false,true,false,false,false,
        false,true,false,false,false
      ]},
    {theDayRecords: [//theDayRecords 签到记录详情⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇⬇
        [{ className: "此月一号的专业班级1名称", studentsNum: "此月一号1班的应到人数", Result: "此月一号1班实到人数", absentStudents: [{ theName: "缺席学生1的姓名", theNumber: "缺席学生1的学号", theMajor: "缺席学生1的专业" }, { theName: "缺席学生2的姓名", theNumber: "缺席学生2的学号", theMajor: "缺席学生2的专业" }] }, { className: "此月一号的专业班级2名称", studentsNum: "此月一号2班的应到人数", Result: "此月一号2班实到人数", absentStudents: [{ theName: "缺席学生1的姓名", theNumber: "缺席学生1的学号", theMajor: "缺席学生1的专业" }, { theName: "缺席学生2的姓名", theNumber: "缺席学生2的学号", theMajor: "缺席学生2的专业" }]}],
        [{ className: "此月二号的专业班级1名称", studentsNum: "此月二号1班的应到人数", Result: "此月二号1班实到人数" }],
        [{ className: "此月三号的专业班级1名称", studentsNum: "此月三号1班的应到人数", Result: "此月三号1班实到人数" }],
        [],//哪一天没有就留空


      ]}
  ];

  var NowDates =
    [ 
        {spaceNum: 6, year: 2018, month: 5, day: 22, monthNum: 31},
        {theDayBool:[
            true,true,true,false,false,false,false,true,true,false,false,true,false,false,false,
            false,true,false,false,false,true,true
        ]},
        {theDayRecords: [
            { time: '8:20:00', majorNames: "安工一班，环科一班，农资三班", signedNum: 80, studentsNum: 82}, {time: '19:40:00', majorNames: "园艺三班，园艺四班", signedNum: 82, studentsNum: 82}
        ]}
    ];
module.exports = {
    NowDates: NowDates
}

//下面不要管⬇⬇⬇⬇⬇⬇⬇
module.exports = {
  NowDates: NowDates
}
