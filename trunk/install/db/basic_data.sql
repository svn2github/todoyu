--
-- Data for Table `ext_contact_person`
--

INSERT INTO `ext_contact_person` (`id`, `date_create`, `date_update`, `id_person_create`, `deleted`, `username`, `password`, `email`, `is_admin`, `is_active`, `firstname`, `lastname`, `shortname`, `salutation`, `title`, `birthday`) VALUES
(1, 1246615200, 1264780312, 0, 0, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'demo@todoyu.com', 1, 1, 'Adam', 'Admin', 'ALAD', 'm', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Data for Table `ext_contact_company`
--

INSERT INTO `ext_contact_company` (`id`, `date_create`, `date_update`, `id_person_create`, `deleted`, `title`, `shortname`, `date_enter`, `is_internal`) VALUES
(1, 1264696524, 1269509610, 1, 0, 'snowflake productions GmbH ', 'sfp', 1259622000, 1);

-- --------------------------------------------------------

--
-- Data for Table `ext_contact_mm_company_person`
--

INSERT INTO `ext_contact_mm_company_person` (`id`, `id_company`, `id_person`, `id_workaddress`, `id_jobtype`) VALUES
(1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Data for Table `ext_contact_contactinfotype`
--

INSERT INTO `ext_contact_contactinfotype` (`id`, `date_create`, `date_update`, `id_person_create`, `deleted`, `category`, `key`, `title`, `is_public`) VALUES
(1, 0, 0, 0, 0, 1, 'email_business', 'LLL:contact.ext.contactinfo.type.email_business', 1),
(2, 0, 0, 0, 0, 2, 'tel_private', 'LLL:contact.ext.contactinfo.type.tel_private', 0),
(3, 0, 0, 0, 0, 2, 'tel_exchange', 'LLL:contact.ext.contactinfo.type.tel_exchange', 1),
(4, 0, 0, 0, 0, 2, 'tel_business', 'LLL:contact.ext.contactinfo.type.tel_business', 1),
(5, 0, 0, 0, 0, 1, 'email_private', 'LLL:contact.ext.contactinfo.type.email_private', 0),
(6, 0, 0, 0, 0, 2, 'mobile_business', 'LLL:contact.ext.contactinfo.type.mobile_business', 1),
(7, 0, 0, 0, 0, 2, 'fax_private', 'LLL:contact.ext.contactinfo.type.fax_private', 0),
(8, 0, 0, 0, 0, 2, 'fax_business', 'LLL:contact.ext.contactinfo.type.fax_business', 1),
(9, 0, 0, 0, 0, 2, 'mobile_private', 'LLL:contact.ext.contactinfo.type.mobile_private', 0),
(10, 0, 0, 0, 0, 2, 'fax_exchange', 'LLL:contact.ext.contactinfo.type.fax_exchange', 1),
(11, 0, 0, 0, 0, 3, 'website', 'LLL:contact.ext.contactinfo.type.website', 1),
(12, 0, 0, 0, 0, 3, 'skype', 'LLL:contact.ext.contactinfo.type.skype', 0);

-- --------------------------------------------------------

--
-- Data for Table `system_role`
--

INSERT INTO `system_role` (`id`, `date_create`, `date_update`, `id_person_create`, `deleted`, `title`, `is_active`, `description`) VALUES
(1, 1264761659, 0, 1, 0, 'Customers', 1, 'Customers with todoyu access'),
(2, 1264762106, 0, 1, 0, 'Project Managers', 1, ''),
(4, 1264762153, 0, 1, 0, 'Staff', 1, 'Executive members of staff');

-- --------------------------------------------------------

--
-- Data for Table `system_right`
--

INSERT INTO `system_right` (`id`, `ext`, `right`, `id_role`) VALUES
(3519, 106, 'person:seeComment', 3),
(1150, 101, 'general:use', 5),
(3619, 119, 'task:editAll', 3),
(19, 120, 'general:use', 5),
(20, 120, 'general:usermanager', 5),
(21, 120, 'user:add', 5),
(22, 120, 'user:edit', 5),
(23, 120, 'user:delete', 5),
(24, 120, 'user:assignGroups', 5),
(25, 120, 'group:add', 5),
(26, 120, 'group:edit', 5),
(27, 120, 'group:delete', 5),
(28, 120, 'group:assignUsers', 5),
(29, 100, 'general:use', 5),
(30, 100, 'panelwidgets:adminmodules', 5),
(696, 107, 'panelwidgets:daytracks', 1),
(3510, 104, 'event:editAll', 3),
(3769, 112, 'addtask:accepted:create', 1),
(3592, 112, 'edittaskdetail:planning:changefrom', 3),
(3469, 112, 'edittaskdetail:planning:changefrom', 2),
(1139, 101, 'asset:seeAll', 3),
(3098, 115, 'filtersets:deleteAll', 4),
(3495, 119, 'task:editOwn', 2),
(2175, 105, 'comment:deleteOwn', 1),
(3391, 105, 'comment:makePublic', 2),
(703, 111, 'general:use', 3),
(1137, 101, 'asset:seeAll', 2),
(3293, 106, 'company:add', 1),
(2841, 101, 'asset:delete', 1),
(1136, 101, 'general:use', 3),
(3767, 112, 'addtask:confirm:create', 1),
(2174, 105, 'comment:sendAsEmail', 1),
(3390, 105, 'comment:sendAsEmail', 2),
(3509, 104, 'event:editAndDeleteAssigned', 3),
(3283, 104, 'event:assignOthers', 1),
(2147, 105, 'comment:makePublic', 3),
(3591, 112, 'edittaskdetail:cleared:changeto', 3),
(3468, 112, 'edittaskdetail:cleared:changeto', 2),
(613, 103, 'general:use', 3),
(611, 103, 'general:use', 2),
(612, 103, 'general:use', 1),
(3383, 104, 'event:editAndDeleteAssigned', 2),
(3282, 104, 'event:add', 1),
(3382, 104, 'event:assignOthers', 2),
(3381, 104, 'event:add', 2),
(3508, 104, 'event:assignOthers', 3),
(2146, 105, 'comment:sendAsEmail', 3),
(2176, 105, 'comment:makePublic', 1),
(2173, 105, 'comment:requestFeedback', 1),
(3399, 106, 'person:enableLogin', 2),
(3518, 106, 'person:editAndDeleteAll', 3),
(3398, 106, 'person:editAndDeleteAll', 2),
(3292, 106, 'company:seeAllCompanies', 1),
(3533, 107, 'daytracks:showHistory', 3),
(695, 107, 'panelwidgets:daytracks', 2),
(692, 107, 'general:use', 2),
(693, 107, 'general:use', 1),
(701, 111, 'general:use', 2),
(702, 111, 'general:use', 1),
(707, 126, 'settings:password', 2),
(3764, 112, 'addtask:planning:create', 1),
(706, 126, 'general:use', 3),
(705, 126, 'general:use', 1),
(709, 126, 'settings:password', 3),
(704, 126, 'general:use', 2),
(708, 126, 'settings:password', 1),
(3766, 112, 'addtask:progress:create', 1),
(3590, 112, 'edittaskdetail:rejected:changeto', 3),
(3467, 112, 'edittaskdetail:rejected:changeto', 2),
(3589, 112, 'edittaskdetail:accepted:changeto', 3),
(3466, 112, 'edittaskdetail:accepted:changeto', 2),
(3765, 112, 'addtask:open:create', 1),
(3588, 112, 'edittaskdetail:done:changeto', 3),
(3465, 112, 'edittaskdetail:done:changeto', 2),
(3763, 112, 'edittask:rejected:edit', 1),
(3762, 112, 'edittask:accepted:edit', 1),
(3587, 112, 'edittaskdetail:confirm:changeto', 3),
(3464, 112, 'edittaskdetail:confirm:changeto', 2),
(3761, 112, 'edittask:done:edit', 1),
(3463, 112, 'edittaskdetail:progress:changeto', 2),
(3462, 112, 'edittaskdetail:open:changeto', 2),
(3760, 112, 'edittask:confirm:edit', 1),
(3586, 112, 'edittaskdetail:progress:changeto', 3),
(932, 115, 'general:area', 3),
(933, 115, 'filtersets:save', 2),
(931, 115, 'general:area', 1),
(930, 115, 'general:area', 2),
(929, 115, 'general:use', 3),
(928, 115, 'general:use', 1),
(927, 115, 'general:use', 2),
(3618, 119, 'task:editOwn', 3),
(3097, 115, 'filtersets:save', 4),
(3494, 119, 'task:track', 2),
(3759, 112, 'edittask:progress:edit', 1),
(3585, 112, 'edittaskdetail:open:changeto', 3),
(3461, 112, 'edittaskdetail:planning:changeto', 2),
(3758, 112, 'edittask:open:edit', 1),
(3757, 112, 'edittask:planning:edit', 1),
(3584, 112, 'edittaskdetail:planning:changeto', 3),
(3460, 112, 'seetask:cleared:see', 2),
(3583, 112, 'seetask:cleared:see', 3),
(3459, 112, 'seetask:rejected:see', 2),
(1140, 101, 'asset:delete', 2),
(1134, 101, 'general:use', 2),
(2840, 101, 'asset:seeAll', 1),
(3507, 104, 'event:add', 3),
(3380, 104, 'event:seeAll', 2),
(3281, 104, 'event:seeAll', 1),
(3379, 104, 'general:area', 2),
(3280, 104, 'general:area', 1),
(2145, 105, 'comment:requestFeedback', 3),
(3389, 105, 'comment:requestFeedback', 2),
(2144, 105, 'comment:editOwn', 4),
(3388, 105, 'comment:editOwn', 2),
(2143, 105, 'comment:seeAll', 3),
(3387, 105, 'comment:seeAll', 2),
(2171, 105, 'comment:seeAll', 1),
(2142, 105, 'general:use', 3),
(3397, 106, 'person:add', 2),
(3291, 106, 'person:add', 1),
(3517, 106, 'person:add', 3),
(3396, 106, 'person:seeAllPersons', 2),
(3290, 106, 'person:seeAllPersons', 1),
(3516, 106, 'person:seeAllPersons', 3),
(698, 107, 'daytracks:showHistory', 2),
(699, 107, 'daytracks:showHistory', 1),
(3532, 107, 'general:use', 3),
(3756, 112, 'edittaskdetail:rejected:changefrom', 1),
(3755, 112, 'edittaskdetail:accepted:changefrom', 1),
(3754, 112, 'edittaskdetail:done:changefrom', 1),
(3582, 112, 'seetask:rejected:see', 3),
(3458, 112, 'seetask:accepted:see', 2),
(3457, 112, 'seetask:done:see', 2),
(3753, 112, 'edittaskdetail:confirm:changefrom', 1),
(1824, 112, 'project:planning:see', 5),
(3581, 112, 'seetask:accepted:see', 3),
(3456, 112, 'seetask:confirm:see', 2),
(3580, 112, 'seetask:done:see', 3),
(3455, 112, 'seetask:progress:see', 2),
(3752, 112, 'edittaskdetail:progress:changefrom', 1),
(3579, 112, 'seetask:confirm:see', 3),
(3454, 112, 'seetask:open:see', 2),
(3751, 112, 'edittaskdetail:open:changefrom', 1),
(3578, 112, 'seetask:progress:see', 3),
(3453, 112, 'seetask:planning:see', 2),
(3750, 112, 'edittaskdetail:planning:changefrom', 1),
(1823, 112, 'edittaskdetail:accepted:changefrom', 5),
(3577, 112, 'seetask:open:see', 3),
(3749, 112, 'edittaskdetail:cleared:changeto', 1),
(3576, 112, 'seetask:planning:see', 3),
(3452, 112, 'edittaskdetail:editIsPublic', 2),
(3575, 112, 'edittaskdetail:editIsPublic', 3),
(3451, 112, 'edittaskdetail:editEstimatedWorkload', 2),
(3450, 112, 'edittaskdetail:editActivity', 2),
(3748, 112, 'edittaskdetail:rejected:changeto', 1),
(3574, 112, 'edittaskdetail:editEstimatedWorkload', 3),
(3449, 112, 'edittaskdetail:editPersonOwner', 2),
(3747, 112, 'edittaskdetail:accepted:changeto', 1),
(3573, 112, 'edittaskdetail:editActivity', 3),
(3448, 112, 'edittaskdetail:editPersonAssigned', 2),
(3746, 112, 'edittaskdetail:done:changeto', 1),
(1822, 112, 'edittaskdetail:done:changefrom', 5),
(3572, 112, 'edittaskdetail:editPersonOwner', 3),
(3744, 112, 'edittaskdetail:progress:changeto', 1),
(2016, 113, 'statuschange:firstreminder', 3),
(2015, 113, 'statuschange:invoiced', 3),
(2013, 113, 'statussee:paid', 3),
(2014, 113, 'statussee:canceled', 3),
(2012, 113, 'statussee:depreciated', 3),
(2011, 113, 'statussee:encashment', 3),
(2009, 113, 'statussee:thirdreminder', 3),
(2010, 113, 'statussee:finalreminder', 3),
(2008, 113, 'statussee:secondreminder', 3),
(2007, 113, 'statussee:firstreminder', 3),
(934, 115, 'filtersets:save', 1),
(935, 115, 'filtersets:save', 3),
(936, 115, 'filtersets:deleteAll', 2),
(937, 115, 'filtersets:deleteAll', 1),
(938, 115, 'filtersets:deleteAll', 3),
(939, 115, 'filtersets:hideAll', 2),
(940, 115, 'filtersets:hideAll', 1),
(941, 115, 'filtersets:hideAll', 3),
(942, 115, 'filtersets:renameAll', 2),
(943, 115, 'filtersets:renameAll', 1),
(944, 115, 'filtersets:renameAll', 3),
(3096, 115, 'general:area', 4),
(3617, 119, 'task:track', 3),
(3493, 119, 'general:use', 2),
(3616, 119, 'general:use', 3),
(3447, 112, 'edittaskdetail:editDeadline', 2),
(3571, 112, 'edittaskdetail:editPersonAssigned', 3),
(3446, 112, 'edittaskdetail:editDateEnd', 2),
(3745, 112, 'edittaskdetail:confirm:changeto', 1),
(1821, 112, 'edittaskdetail:confirm:changefrom', 5),
(1820, 112, 'edittaskdetail:rejected:changeto', 5),
(3743, 112, 'edittaskdetail:open:changeto', 1),
(1819, 112, 'edittaskdetail:accepted:changeto', 5),
(3570, 112, 'edittaskdetail:editDeadline', 3),
(3742, 112, 'edittaskdetail:planning:changeto', 1),
(3445, 112, 'edittaskdetail:editDateStart', 2),
(1818, 112, 'seetask:cleared:see', 5),
(3569, 112, 'edittaskdetail:editDateEnd', 3),
(3444, 112, 'task:editStatus', 2),
(3741, 112, 'seetask:cleared:see', 1),
(1817, 112, 'seetask:rejected:see', 5),
(3568, 112, 'edittaskdetail:editDateStart', 3),
(3443, 112, 'deletetask:deleteOwnTasks', 2),
(3740, 112, 'seetask:rejected:see', 1),
(3567, 112, 'task:editStatus', 3),
(3442, 112, 'deletetask:deleteTaskInAllProjects', 2),
(3739, 112, 'seetask:accepted:see', 1),
(1816, 112, 'seetask:accepted:see', 5),
(3378, 104, 'general:use', 2),
(3506, 104, 'event:seeAll', 3),
(3279, 104, 'general:use', 1),
(1196, 105, 'comment:requestFeedback', 5),
(1195, 105, 'comment:editOwn', 5),
(1194, 105, 'general:use', 5),
(1157, 126, 'general:use', 5),
(1158, 126, 'settings:password', 5),
(1159, 111, 'general:use', 5),
(1815, 112, 'seetask:done:see', 5),
(3566, 112, 'deletetask:deleteOwnTasks', 3),
(3441, 112, 'deletetask:deleteTaskInOwnProjects', 2),
(3440, 112, 'edittask:editOwnTasks', 2),
(3738, 112, 'seetask:done:see', 1),
(1169, 2356, 'general:use', 6),
(2839, 101, 'general:use', 1),
(2170, 105, 'general:use', 1),
(3386, 105, 'general:use', 2),
(1197, 105, 'comment:makePublic', 5),
(3439, 112, 'edittask:editTaskInAllProjects', 2),
(3565, 112, 'deletetask:deleteTaskInAllProjects', 3),
(3438, 112, 'edittask:editTaskInOwnProjects', 2),
(3737, 112, 'seetask:confirm:see', 1),
(3564, 112, 'deletetask:deleteTaskInOwnProjects', 3),
(3437, 112, 'addtask:addViaQuickCreateHeadlet', 2),
(3736, 112, 'seetask:progress:see', 1),
(3563, 112, 'edittask:editOwnTasks', 3),
(3733, 112, 'edittaskdetail:editIsPublic', 1),
(1341, 115, 'general:use', 5),
(3735, 112, 'seetask:open:see', 1),
(3562, 112, 'edittask:editTaskInAllProjects', 3),
(3561, 112, 'edittask:editTaskInOwnProjects', 3),
(3436, 112, 'addtask:addTaskInAllProjects', 2),
(3734, 112, 'seetask:planning:see', 1),
(3560, 112, 'addtask:addViaQuickCreateHeadlet', 3),
(3435, 112, 'addtask:addTaskInOwnProjects', 2),
(3434, 112, 'seetask:seeAll', 2),
(3732, 112, 'edittaskdetail:editEstimatedWorkload', 1),
(1814, 112, 'seetask:confirm:see', 5),
(3559, 112, 'addtask:addTaskInAllProjects', 3),
(3730, 112, 'edittaskdetail:editPersonOwner', 1),
(1813, 112, 'seetask:progress:see', 5),
(3558, 112, 'addtask:addTaskInOwnProjects', 3),
(3433, 112, 'deletetask:deleteContainerInAllProjects', 2),
(3728, 112, 'edittaskdetail:editDeadline', 1),
(3557, 112, 'seetask:seeAll', 3),
(1812, 112, 'seetask:open:see', 5),
(3556, 112, 'deletetask:deleteContainerInAllProjects', 3),
(3432, 112, 'deletetask:deleteContainerInOwnProjects', 2),
(3731, 112, 'edittaskdetail:editActivity', 1),
(3729, 112, 'edittaskdetail:editPersonAssigned', 1),
(3555, 112, 'deletetask:deleteContainerInOwnProjects', 3),
(1811, 112, 'seetask:planning:see', 5),
(3554, 112, 'deletetask:deleteOwnContainers', 3),
(3431, 112, 'deletetask:deleteOwnContainers', 2),
(3727, 112, 'edittaskdetail:editDateEnd', 1),
(3553, 112, 'edittask:editContainerInAllProjects', 3),
(3430, 112, 'edittask:editContainerInAllProjects', 2),
(3726, 112, 'edittaskdetail:editDateStart', 1),
(1810, 112, 'task:editStatus', 5),
(3429, 112, 'edittask:editContainerInOwnProjects', 2),
(3725, 112, 'task:editStatus', 1),
(3428, 112, 'edittask:editOwnContainers', 2),
(3723, 112, 'deletetask:deleteTaskInAllProjects', 1),
(1809, 112, 'task:editAndDeleteOwnTasks', 5),
(3552, 112, 'edittask:editContainerInOwnProjects', 3),
(3427, 112, 'addtask:addContainerInAllProjects', 2),
(3724, 112, 'deletetask:deleteOwnTasks', 1),
(3551, 112, 'edittask:editOwnContainers', 3),
(3426, 112, 'addtask:addContainerInOwnProjects', 2),
(3722, 112, 'deletetask:deleteTaskInOwnProjects', 1),
(1808, 112, 'task:editAndDeleteInOwnProjects', 5),
(3721, 112, 'edittask:editOwnTasks', 1),
(3425, 112, 'edittask:useTaskAndContainerClipboard', 2),
(3550, 112, 'addtask:addContainerInAllProjects', 3),
(3720, 112, 'edittask:editTaskInAllProjects', 1),
(3549, 112, 'addtask:addContainerInOwnProjects', 3),
(3424, 112, 'project:warranty:see', 2),
(3718, 112, 'addtask:addViaQuickCreateHeadlet', 1),
(1807, 112, 'addtask:addTaskInOwnProjects', 5),
(3548, 112, 'edittask:useTaskAndContainerClipboard', 3),
(1806, 112, 'seetask:seeAll', 5),
(3423, 112, 'project:cleared:see', 2),
(3719, 112, 'edittask:editTaskInOwnProjects', 1),
(1805, 112, 'project:seeOwn', 5),
(3547, 112, 'project:warranty:see', 3),
(3422, 112, 'project:done:see', 2),
(3717, 112, 'addtask:addTaskInAllProjects', 1),
(1804, 112, 'general:area', 5),
(1803, 112, 'general:use', 5),
(3546, 112, 'project:cleared:see', 3),
(2006, 113, 'statussee:invoiced', 3),
(2005, 113, 'statussee:approved', 3),
(2004, 113, 'statussee:provisional', 3),
(1825, 112, 'project:progress:see', 5),
(1826, 112, 'project:done:see', 5),
(1827, 112, 'project:cleared:see', 5),
(1828, 112, 'project:warranty:see', 5),
(1829, 131, 'general:use', 2),
(1830, 132, 'general:use', 2),
(3421, 112, 'project:progress:see', 2),
(2003, 113, 'task:infos', 3),
(2002, 113, 'task:icons', 3),
(2001, 113, 'project:documents', 3),
(2000, 113, 'project:infos', 3),
(1999, 113, 'project:approvalroles', 3),
(1998, 113, 'tab:invoices', 3),
(1997, 113, 'tab:billing', 3),
(1996, 113, 'general:area', 3),
(1995, 113, 'general:use', 3),
(2023, 113, 'statuschange:canceled', 3),
(2024, 113, 'workflow:approve', 3),
(2025, 113, 'workflow:reopen', 3),
(2026, 113, 'workflow:download', 3),
(2027, 132, 'general:use', 3),
(2888, 101, 'general:use', 4),
(3716, 112, 'addtask:addTaskInOwnProjects', 1),
(3715, 112, 'seetask:seeAll', 1),
(2085, 111, 'general:use', 4),
(2086, 126, 'general:use', 4),
(2087, 126, 'settings:password', 4),
(3714, 112, 'deletetask:deleteContainerInAllProjects', 1),
(2838, 119, 'task:editOwn', 1),
(2837, 119, 'task:track', 1),
(2836, 119, 'general:use', 1),
(3707, 112, 'addtask:addContainerInOwnProjects', 1),
(3298, 106, 'panelwidgets:staffSelector', 1),
(3768, 112, 'addtask:done:create', 1),
(3296, 106, 'relation:seeBusinessAddress', 1),
(3295, 106, 'relation:seeHomeAddress', 1),
(3294, 106, 'relation:seeAllContactinfotypes', 1),
(3284, 104, 'event:editAndDeleteAssigned', 1),
(3285, 104, 'mailing:sendAsEmail', 1),
(3713, 112, 'deletetask:deleteContainerInOwnProjects', 1),
(3712, 112, 'deletetask:deleteOwnContainers', 1),
(3297, 106, 'relation:seeBillingAddress', 1),
(3710, 112, 'edittask:editContainerInOwnProjects', 1),
(3420, 112, 'project:planning:see', 2),
(3419, 112, 'project:editAndDelete', 2),
(3418, 112, 'project:seeAll', 2),
(3545, 112, 'project:done:see', 3),
(3544, 112, 'project:progress:see', 3),
(3543, 112, 'project:planning:see', 3),
(3417, 112, 'project:seeOwn', 2),
(3416, 112, 'project:add', 2),
(3415, 112, 'general:area', 2),
(3414, 112, 'general:use', 2),
(3711, 112, 'edittask:editContainerInAllProjects', 1),
(3709, 112, 'edittask:editOwnContainers', 1),
(3708, 112, 'addtask:addContainerInAllProjects', 1),
(3275, 112, 'edittaskdetail:done:changefrom', 4),
(3274, 112, 'edittaskdetail:confirm:changefrom', 4),
(3273, 112, 'edittaskdetail:rejected:changeto', 4),
(3272, 112, 'edittaskdetail:accepted:changeto', 4),
(3271, 112, 'seetask:cleared:see', 4),
(3270, 112, 'seetask:rejected:see', 4),
(3269, 112, 'seetask:accepted:see', 4),
(3542, 112, 'project:editAndDelete', 3),
(3541, 112, 'project:seeAll', 3),
(3540, 112, 'project:seeOwn', 3),
(3539, 112, 'project:add', 3),
(3538, 112, 'general:area', 3),
(3537, 112, 'general:use', 3),
(3289, 106, 'person:seeAllInternalPersons', 1),
(3288, 106, 'general:area', 1),
(3287, 106, 'general:profile', 1),
(3286, 106, 'general:use', 1),
(3395, 106, 'person:seeAllInternalPersons', 2),
(3394, 106, 'general:area', 2),
(3393, 106, 'general:profile', 2),
(3392, 106, 'general:use', 2),
(3515, 106, 'person:seeAllInternalPersons', 3),
(3514, 106, 'general:area', 3),
(3513, 106, 'general:profile', 3),
(3512, 106, 'general:use', 3),
(3268, 112, 'seetask:done:see', 4),
(3267, 112, 'seetask:confirm:see', 4),
(3266, 112, 'seetask:progress:see', 4),
(3265, 112, 'seetask:open:see', 4),
(3264, 112, 'seetask:planning:see', 4),
(3263, 112, 'task:editStatus', 4),
(3262, 112, 'edittask:editOwnTasks', 4),
(3261, 112, 'edittask:editTaskInOwnProjects', 4),
(3259, 112, 'seetask:seeAll', 4),
(3260, 112, 'addtask:addTaskInOwnProjects', 4),
(3258, 112, 'project:warranty:see', 4),
(3257, 112, 'project:done:see', 4),
(3095, 115, 'general:use', 4),
(3278, 105, 'comment:sendAsEmail', 4),
(3277, 105, 'comment:requestFeedback', 4),
(3276, 105, 'general:use', 4),
(2942, 106, 'general:use', 4),
(2943, 106, 'general:profile', 4),
(3194, 103, 'general:use', 4),
(3256, 112, 'project:progress:see', 4),
(3255, 112, 'project:planning:see', 4),
(3254, 112, 'project:seeOwn', 4),
(3099, 115, 'filtersets:hideAll', 4),
(3100, 115, 'filtersets:renameAll', 4),
(3253, 112, 'general:area', 4),
(3252, 112, 'general:use', 4),
(3706, 112, 'edittask:useTaskAndContainerClipboard', 1),
(3705, 112, 'project:warranty:see', 1),
(3704, 112, 'project:cleared:see', 1),
(3703, 112, 'project:done:see', 1),
(3702, 112, 'project:progress:see', 1),
(3701, 112, 'project:planning:see', 1),
(3700, 112, 'project:editAndDelete', 1),
(3699, 112, 'project:seeAll', 1),
(3698, 112, 'project:seeOwn', 1),
(3697, 112, 'project:add', 1),
(3696, 112, 'general:area', 1),
(3695, 112, 'general:use', 1),
(3384, 104, 'event:editAll', 2),
(3385, 104, 'mailing:sendAsEmail', 2),
(3400, 106, 'person:seeComment', 2),
(3401, 106, 'person:editComment', 2),
(3402, 106, 'company:seeAllCompanies', 2),
(3403, 106, 'company:add', 2),
(3404, 106, 'company:editOwn', 2),
(3405, 106, 'company:editAndDeleteAll', 2),
(3406, 106, 'company:seeComment', 2),
(3407, 106, 'company:editComment', 2),
(3408, 106, 'relation:seeAllContactinfotypes', 2),
(3409, 106, 'relation:seeHomeAddress', 2),
(3410, 106, 'relation:seeBusinessAddress', 2),
(3411, 106, 'relation:seeBillingAddress', 2),
(3412, 106, 'panelwidgets:staffSelector', 2),
(3413, 106, 'panelwidgets:export', 2),
(3470, 112, 'edittaskdetail:open:changefrom', 2),
(3471, 112, 'edittaskdetail:progress:changefrom', 2),
(3472, 112, 'edittaskdetail:confirm:changefrom', 2),
(3473, 112, 'edittaskdetail:done:changefrom', 2),
(3474, 112, 'edittaskdetail:accepted:changefrom', 2),
(3475, 112, 'edittaskdetail:rejected:changefrom', 2),
(3476, 112, 'edittask:planning:edit', 2),
(3477, 112, 'edittask:open:edit', 2),
(3478, 112, 'edittask:progress:edit', 2),
(3479, 112, 'edittask:confirm:edit', 2),
(3480, 112, 'edittask:done:edit', 2),
(3481, 112, 'edittask:accepted:edit', 2),
(3482, 112, 'edittask:rejected:edit', 2),
(3483, 112, 'addtask:planning:create', 2),
(3484, 112, 'addtask:open:create', 2),
(3485, 112, 'addtask:progress:create', 2),
(3486, 112, 'addtask:confirm:create', 2),
(3487, 112, 'addtask:done:create', 2),
(3488, 112, 'addtask:accepted:create', 2),
(3489, 112, 'addtask:rejected:create', 2),
(3490, 112, 'addtask:cleared:create', 2),
(3491, 112, 'export:taskcsv', 2),
(3492, 112, 'export:projectcsv', 2),
(3505, 104, 'general:area', 3),
(3504, 104, 'general:use', 3),
(3511, 104, 'mailing:sendAsEmail', 3),
(3520, 106, 'person:editComment', 3),
(3521, 106, 'company:seeAllCompanies', 3),
(3522, 106, 'company:add', 3),
(3523, 106, 'company:editOwn', 3),
(3524, 106, 'company:seeComment', 3),
(3525, 106, 'company:editComment', 3),
(3526, 106, 'relation:seeAllContactinfotypes', 3),
(3527, 106, 'relation:seeHomeAddress', 3),
(3528, 106, 'relation:seeBusinessAddress', 3),
(3529, 106, 'relation:seeBillingAddress', 3),
(3530, 106, 'panelwidgets:staffSelector', 3),
(3531, 106, 'panelwidgets:export', 3),
(3534, 107, 'daytracks:timeExport', 3),
(3535, 107, 'daytracks:timeExportAllPerson', 3),
(3536, 107, 'daytracks:timeExportAllEmployer', 3),
(3593, 112, 'edittaskdetail:open:changefrom', 3),
(3594, 112, 'edittaskdetail:progress:changefrom', 3),
(3595, 112, 'edittaskdetail:confirm:changefrom', 3),
(3596, 112, 'edittaskdetail:done:changefrom', 3),
(3597, 112, 'edittaskdetail:accepted:changefrom', 3),
(3598, 112, 'edittaskdetail:rejected:changefrom', 3),
(3599, 112, 'edittaskdetail:cleared:changefrom', 3),
(3600, 112, 'edittask:planning:edit', 3),
(3601, 112, 'edittask:open:edit', 3),
(3602, 112, 'edittask:progress:edit', 3),
(3603, 112, 'edittask:confirm:edit', 3),
(3604, 112, 'edittask:done:edit', 3),
(3605, 112, 'edittask:accepted:edit', 3),
(3606, 112, 'edittask:rejected:edit', 3),
(3607, 112, 'edittask:cleared:edit', 3),
(3608, 112, 'addtask:planning:create', 3),
(3609, 112, 'addtask:open:create', 3),
(3610, 112, 'addtask:progress:create', 3),
(3611, 112, 'addtask:confirm:create', 3),
(3612, 112, 'addtask:done:create', 3),
(3613, 112, 'addtask:accepted:create', 3),
(3614, 112, 'addtask:rejected:create', 3),
(3615, 112, 'addtask:cleared:create', 3),
(3770, 112, 'addtask:rejected:create', 1),
(3771, 112, 'addtask:cleared:create', 1),
(3772, 104, 'event:deleteAll', 3),
(3773, 104, 'event:deleteAll', 2),
(3774, 105, 'comment:deleteOwn', 2),
(3775, 105, 'comment:deleteOwn', 4);