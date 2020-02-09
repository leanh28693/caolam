/*!

=========================================================
* Material Dashboard React - v1.8.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard-react
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/material-dashboard-react/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
// @material-ui/icons
import Dashboard from "@material-ui/icons/Dashboard";
import AddBox from "@material-ui/icons/AddBox";
import Person from "@material-ui/icons/Person";
import LibraryBooks from "@material-ui/icons/LibraryBooks";
import BubbleChart from "@material-ui/icons/BubbleChart";
import LocationOn from "@material-ui/icons/LocationOn";
import Notifications from "@material-ui/icons/Notifications";
import Unarchive from "@material-ui/icons/Unarchive";
import Alarm from "@material-ui/icons/Alarm";
// core components/views for Admin layout
import DashboardPage from "views/Dashboard/Dashboard.js";
import AddBoxPage from "views/AddToFlast/Dashboard.js";
import UserProfile from "views/UserProfile/UserProfile.js";
import LichTrinh from "views/lichtrinh/TableList";
import TableList from "views/TableList/TableList.js";
import TableChuyen from "views/chuyenxe/TableChuyen";
import Typography from "views/Typography/Typography.js";
import Icons from "views/Icons/Icons.js";
import Maps from "views/Maps/Maps.js";
import NotificationsPage from "views/Notifications/Notifications.js";
import UpgradeToPro from "views/UpgradeToPro/UpgradeToPro.js";
import AddBus from "views/TableList/AddBus";
import EditBus from "views/TableList/EditBus";

import AddChuyen from "views/chuyenxe/AddChuyen";
import EditChuyen from "views/chuyenxe/EditChuyen";
import Printer from "views/lichtrinh/Printer";
import Customers from "views/lichtrinh/Customers";
import Build from "@material-ui/icons/Build";
// core components/views for RTL layout
import RTLPage from "views/RTLPage/RTLPage.js";

const dashboardRoutes = [
  {
    path: "/addflast",
    name: "Thêm vé nhanh",
    rtlName: "لوحة القيادة",
    icon: AddBox,
    component: AddBoxPage,
    layout: "/admin"
  }
  // ,
  // {
  //   path: "/dashboard",
  //   name: "Tổng quan",
  //   rtlName: "لوحة القيادة",
  //   icon: Dashboard,
  //   component: DashboardPage,
  //   layout: "/admin"
  // }
  ,
  {
    path: "/lich-trinh",
    name: "Lịch Trình",
    rtlName: "ملف تعريفي للمستخدم",
    icon: Person,
    component: LichTrinh,
    layout: "/admin"
  },
  {
    path: "/table",
    name: "Quản lý xe",
    rtlName: "قائمة الجدول",
    icon: "content_paste",
    component: TableList,
    layout: "/admin"
  },
  {
    path: "/chuyen-xe",
    name: "Quản lý chuyến xe",
    rtlName: "طباعة",
    icon: Alarm,
    component: TableChuyen,
    layout: "/admin"
  }
  ,
  {
    path: "/icons",
    name: "Quản lý hàng hóa",
    rtlName: "الرموز",
    icon: BubbleChart,
    component: Icons,
    layout: "/admin"
  }
  // ,
  // {
  //   path: "/maps",
  //   name: "Quản lý tin nhắn",
  //   rtlName: "خرائط",
  //   icon: LocationOn,
  //   component: Maps,
  //   layout: "/admin"
  // },
  // {
  //   path: "/notifications",
  //   name: "Quản lý xe cho thuê",
  //   rtlName: "إخطارات",
  //   icon: Notifications,
  //   component: NotificationsPage,
  //   layout: "/admin"
  // },
  // {
  //   path: "/rtl-page",
  //   name: "RTL Support",
  //   rtlName: "پشتیبانی از راست به چپ",
  //   icon: Language,
  //   component: RTLPage,
  //   layout: "/rtl"
  //  }
  //  ,
  // {
  //   path: "/upgrade-to-pro",
  //   name: "Upgrade To PRO",
  //   rtlName: "التطور للاحترافية",
  //   icon: Unarchive,
  //   component: UpgradeToPro,
  //   layout: "/admin"
  // }
  ,{
      path: "/addbus",
      name: "Thêm xe",
      rtlName: "التطور للاحترافية",
      icon: AddBox,
      component:AddBus ,
      hidesidebar:true,
      layout: "/admin"
  },
  {
    path: "/editbus/:urlID",
    name: "chỉnh sữa xe",
    rtlName: "التطور للاحترافية",
    icon: Build,
    component:EditBus ,
    hidesidebar:true,
    layout: "/admin"
},{
  path: "/them-chuyen",
  name: "Thêm xe",
  rtlName: "التطور للاحترافية",
  icon: AddBox,
  component:AddChuyen ,
  hidesidebar:true,
  layout: "/admin"
},
{
path: "/sua-chuyen/:urlID",
name: "chỉnh sữa xe",
rtlName: "التطور للاحترافية",
icon: Build,
component:EditChuyen ,
hidesidebar:true,
layout: "/admin"
}
,
{
path: "/print/:id",
name: "printer",
rtlName: "التطور للاحترافية",
icon: Build,
component:Printer ,
hidesidebar:true,
layout: "/admin"
}
,
{
path: "/customer/:id_tuyen/:id_chuyen/:start_time",
name: "customer",
rtlName: "التطور للاحترافية",
icon: Build,
component:Customers ,
hidesidebar:true,
layout: "/admin"
}
];

export default dashboardRoutes;
