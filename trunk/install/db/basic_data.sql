--
-- Data for Table `ext_contact_person`
--

INSERT INTO `ext_contact_person` (`id`, `date_create`, `date_update`, `id_person_create`, `deleted`, `username`, `password`, `email`, `is_admin`, `active`, `firstname`, `lastname`, `shortname`, `salutation`, `title`, `birthday`) VALUES
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

INSERT INTO `ext_contact_contactinfotype` (`id`, `date_create`, `date_update`, `id_person_create`, `deleted`, `category`, `key`, `title`) VALUES
(1, 0, 0, 0, 0, 1, 'email_business', 'LLL:contact.ext.contactinfo.type.email_business'),
(2, 0, 0, 0, 0, 2, 'tel_private', 'LLL:contact.ext.contactinfo.type.tel_private'),
(3, 0, 0, 0, 0, 2, 'tel_exchange', 'LLL:contact.ext.contactinfo.type.tel_exchange'),
(4, 0, 0, 0, 0, 2, 'tel_business', 'LLL:contact.ext.contactinfo.type.tel_business'),
(5, 0, 0, 0, 0, 1, 'email_private', 'LLL:contact.ext.contactinfo.type.email_private'),
(6, 0, 0, 0, 0, 2, 'mobile_business', 'LLL:contact.ext.contactinfo.type.mobile_business'),
(7, 0, 0, 0, 0, 2, 'fax_private', 'LLL:contact.ext.contactinfo.type.fax_private'),
(8, 0, 0, 0, 0, 2, 'fax_business', 'LLL:contact.ext.contactinfo.type.fax_business'),
(9, 0, 0, 0, 0, 2, 'mobile_private', 'LLL:contact.ext.contactinfo.type.mobile_private'),
(10, 0, 0, 0, 0, 2, 'fax_exchange', 'LLL:contact.ext.contactinfo.type.fax_exchange'),
(11, 0, 0, 0, 0, 3, 'website', 'LLL:contact.ext.contactinfo.type.website'),
(12, 0, 0, 0, 0, 3, 'skype', 'LLL:contact.ext.contactinfo.type.skype');

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
(31, 112, 'clipboard:useTaskAndContainerClipboard', 2),
(32, 112, 'container:addInOwnProjects', 2),
(33, 112, 'container:addInAllProjects', 2),
(34, 112, 'clipboard:useTaskAndContainerClipboard', 4),
(35, 112, 'container:addInOwnProjects', 4),
(36, 112, 'container:addInAllProjects', 4),
(37, 112, 'container:addInOwnProjects', 1),
(50, 112, 'container:editAndDeleteInAllProjects', 2),
(51, 112, 'container:editAndDeleteInOwnProjects', 2),
(52, 112, 'container:editAndDeleteOwnContainers', 2),
(53, 112, 'container:editAndDeleteInAllProjects', 4),
(54, 112, 'container:editAndDeleteInOwnProjects', 4),
(55, 112, 'container:editAndDeleteOwnContainers', 4),
(107, 103, 'general:use', 4),
(108, 103, 'task:add', 4),
(109, 103, 'task:remove', 4),
(110, 103, 'panelwidgets:taskbookmarks', 4),
(125, 107, 'general:use', 4),
(126, 107, 'panelwidgets:daytracks', 4),
(127, 107, 'daytracks:showHistory', 4),
(189, 104, 'general:use', 1),
(190, 105, 'general:use', 1),
(191, 105, 'comment:requestFeedback', 1),
(192, 105, 'comment:sendAsEmail', 1),
(193, 106, 'general:use', 1),
(194, 111, 'general:use', 1),
(195, 126, 'general:use', 1),
(196, 126, 'settings:password', 1),
(197, 115, 'general:use', 1),
(198, 119, 'general:use', 2),
(199, 119, 'general:use', 4),
(200, 119, 'task:track', 2),
(201, 119, 'task:track', 4),
(202, 119, 'task:editOwn', 2),
(203, 119, 'task:editOwn', 4),
(220, 101, 'general:use', 2),
(221, 101, 'asset:seeAll', 2),
(222, 101, 'asset:delete', 2),
(223, 101, 'general:use', 1),
(224, 104, 'general:use', 1),
(225, 105, 'general:use', 1),
(226, 105, 'comment:requestFeedback', 1),
(227, 105, 'comment:sendAsEmail', 1),
(228, 106, 'general:use', 1),
(229, 126, 'general:use', 1),
(230, 126, 'settings:password', 1),
(231, 101, 'general:use', 4),
(232, 101, 'asset:seeAll', 4),
(237, 103, 'general:use', 4),
(238, 103, 'task:add', 4),
(239, 103, 'task:remove', 4),
(240, 103, 'panelwidgets:taskbookmarks', 4),
(241, 104, 'general:use', 4),
(242, 104, 'general:area', 4),
(243, 104, 'event:seeAll', 4),
(244, 104, 'event:add', 4),
(245, 104, 'event:assignOthers', 4),
(246, 104, 'event:editAndDeleteAssigned', 4),
(247, 105, 'general:use', 4),
(248, 105, 'comment:seeAll', 4),
(249, 105, 'comment:editOwn', 4),
(250, 105, 'comment:requestFeedback', 4),
(251, 105, 'comment:sendAsEmail', 4),
(252, 106, 'general:use', 4),
(253, 106, 'general:area', 4),
(254, 106, 'panelwidgets:staffSelector', 4),
(255, 111, 'general:use', 4),
(256, 126, 'general:use', 4),
(257, 126, 'settings:password', 4),
(258, 103, 'general:use', 2),
(259, 103, 'general:use', 4),
(261, 103, 'task:add', 2),
(262, 103, 'task:add', 4),
(263, 103, 'task:remove', 2),
(264, 103, 'task:remove', 4),
(265, 103, 'panelwidgets:taskbookmarks', 2),
(266, 103, 'panelwidgets:taskbookmarks', 4),
(267, 104, 'general:use', 2),
(268, 104, 'general:use', 4),
(269, 104, 'general:use', 1),
(270, 104, 'general:area', 2),
(271, 104, 'general:area', 4),
(272, 104, 'event:seeAll', 2),
(273, 104, 'event:seeAll', 4),
(274, 104, 'event:add', 2),
(275, 104, 'event:add', 4),
(276, 104, 'event:assignOthers', 2),
(277, 104, 'event:assignOthers', 4),
(278, 104, 'event:editAndDeleteAssigned', 2),
(279, 104, 'event:editAndDeleteAssigned', 4),
(280, 104, 'event:editAndDeleteAll', 2),
(281, 105, 'general:use', 2),
(282, 105, 'general:use', 4),
(283, 105, 'general:use', 1),
(284, 105, 'comment:seeAll', 2),
(285, 105, 'comment:seeAll', 4),
(286, 105, 'comment:editOwn', 2),
(287, 105, 'comment:editOwn', 4),
(288, 105, 'comment:requestFeedback', 2),
(289, 105, 'comment:requestFeedback', 4),
(290, 105, 'comment:requestFeedback', 1),
(291, 105, 'comment:sendAsEmail', 2),
(292, 105, 'comment:sendAsEmail', 4),
(293, 105, 'comment:sendAsEmail', 1),
(294, 106, 'general:use', 2),
(295, 106, 'general:use', 4),
(296, 106, 'general:use', 1),
(297, 106, 'general:area', 2),
(298, 106, 'general:area', 4),
(299, 106, 'person:add', 2),
(300, 106, 'person:editAndDelete', 2),
(301, 106, 'person:enableLogin', 2),
(302, 106, 'company:add', 2),
(303, 106, 'company:editAndDelete', 2),
(304, 106, 'panelwidgets:staffSelector', 2),
(305, 106, 'panelwidgets:staffSelector', 4),
(306, 107, 'general:use', 2),
(307, 107, 'general:use', 4),
(308, 107, 'panelwidgets:daytracks', 2),
(309, 107, 'panelwidgets:daytracks', 4),
(310, 107, 'daytracks:showHistory', 2),
(311, 107, 'daytracks:showHistory', 4),
(312, 111, 'general:use', 2),
(313, 111, 'general:use', 4),
(314, 111, 'general:use', 1),
(315, 126, 'general:use', 2),
(316, 126, 'general:use', 4),
(317, 126, 'general:use', 1),
(318, 126, 'settings:password', 2),
(319, 126, 'settings:password', 4),
(320, 126, 'settings:password', 1),
(321, 126, 'general:use', 2),
(322, 126, 'general:use', 4),
(323, 126, 'general:use', 1),
(324, 126, 'settings:password', 2),
(325, 126, 'settings:password', 4),
(326, 126, 'settings:password', 1),
(419, 115, 'general:use', 2),
(420, 115, 'general:use', 4),
(421, 115, 'general:use', 1),
(422, 115, 'general:area', 2),
(423, 115, 'general:area', 4),
(424, 115, 'filtersets:save', 2),
(425, 115, 'filtersets:save', 4),
(426, 115, 'filtersets:deleteAll', 2),
(427, 115, 'filtersets:hideAll', 2),
(428, 115, 'filtersets:renameAll', 2),
(429, 119, 'general:use', 2),
(430, 119, 'general:use', 4),
(431, 119, 'task:track', 2),
(432, 119, 'task:track', 4),
(433, 119, 'task:editOwn', 2),
(434, 119, 'task:editOwn', 4),
(475, 112, 'general:use', 1),
(476, 112, 'general:area', 1),
(477, 112, 'project:seeOwn', 1),
(478, 112, 'task:seeAll', 1),
(479, 112, 'task:addInOwnProjects', 1),
(480, 112, 'taskstatus:planning:see', 1),
(481, 112, 'taskstatus:done:see', 1),
(482, 112, 'taskstatus:accepted:see', 1),
(483, 112, 'taskstatus:cleared:see', 1),
(484, 112, 'taskstatus:customer:see', 1),
(485, 112, 'projectstatus:progress:see', 1),
(486, 112, 'projectstatus:done:see', 1),
(487, 112, 'projectstatus:cleared:see', 1),
(488, 112, 'projectstatus:warranty:see', 1),
(519, 112, 'general:use', 2),
(520, 112, 'general:area', 2),
(521, 112, 'project:add', 2),
(522, 112, 'project:seeOwn', 2),
(523, 112, 'project:seeAll', 2),
(524, 112, 'project:editAndDelete', 2),
(525, 112, 'task:seeAll', 2),
(526, 112, 'task:addViaQuickCreateHeadlet', 2),
(527, 112, 'task:addInOwnProjects', 2),
(528, 112, 'task:addInAllProjects', 2),
(529, 112, 'task:editAndDeleteInOwnProjects', 2),
(530, 112, 'task:editAndDeleteInAllProjects', 2),
(531, 112, 'task:editStatus', 2),
(532, 112, 'task:editDateStart', 2),
(533, 112, 'task:editDateEnd', 2),
(534, 112, 'task:editDeadline', 2),
(535, 112, 'task:editPersonAssigned', 2),
(536, 112, 'task:editPersonOwner', 2),
(537, 112, 'task:editActivity', 2),
(538, 112, 'task:editEstimatedWorkload', 2),
(539, 112, 'task:editIsPublic', 2),
(540, 112, 'taskstatus:planning:see', 2),
(541, 112, 'taskstatus:open:see', 2),
(542, 112, 'taskstatus:progress:see', 2),
(543, 112, 'taskstatus:confirm:see', 2),
(544, 112, 'taskstatus:done:see', 2),
(545, 112, 'taskstatus:accepted:see', 2),
(546, 112, 'taskstatus:rejected:see', 2),
(547, 112, 'taskstatus:cleared:see', 2),
(548, 112, 'taskstatus:customer:see', 2),
(549, 112, 'taskstatus:planning:changeto', 2),
(550, 112, 'taskstatus:open:changeto', 2),
(551, 112, 'taskstatus:progress:changeto', 2),
(552, 112, 'taskstatus:confirm:changeto', 2),
(553, 112, 'taskstatus:done:changeto', 2),
(554, 112, 'taskstatus:accepted:changeto', 2),
(555, 112, 'taskstatus:rejected:changeto', 2),
(556, 112, 'taskstatus:cleared:changeto', 2),
(557, 112, 'taskstatus:planning:edit', 2),
(558, 112, 'taskstatus:open:edit', 2),
(559, 112, 'taskstatus:progress:edit', 2),
(560, 112, 'taskstatus:confirm:edit', 2),
(561, 112, 'taskstatus:done:edit', 2),
(562, 112, 'taskstatus:accepted:edit', 2),
(563, 112, 'taskstatus:rejected:edit', 2),
(564, 112, 'taskstatus:cleared:edit', 2),
(565, 112, 'taskstatus:customer:edit', 2),
(566, 112, 'projectstatus:planning:see', 2),
(567, 112, 'projectstatus:progress:see', 2),
(568, 112, 'projectstatus:done:see', 2),
(569, 112, 'projectstatus:cleared:see', 2),
(570, 112, 'projectstatus:warranty:see', 2),
(571, 112, 'general:use', 4),
(572, 112, 'general:area', 4),
(573, 112, 'project:seeOwn', 4),
(574, 112, 'project:seeAll', 4),
(575, 112, 'task:seeAll', 4),
(576, 112, 'task:addViaQuickCreateHeadlet', 4),
(577, 112, 'task:addInOwnProjects', 4),
(578, 112, 'task:editAndDeleteInOwnProjects', 4),
(579, 112, 'task:editStatus', 4),
(580, 112, 'task:editDateStart', 4),
(581, 112, 'task:editDateEnd', 4),
(582, 112, 'task:editDeadline', 4),
(583, 112, 'task:editPersonAssigned', 4),
(584, 112, 'task:editActivity', 4),
(585, 112, 'taskstatus:planning:see', 4),
(586, 112, 'taskstatus:open:see', 4),
(587, 112, 'taskstatus:progress:see', 4),
(588, 112, 'taskstatus:confirm:see', 4),
(589, 112, 'taskstatus:done:see', 4),
(590, 112, 'taskstatus:accepted:see', 4),
(591, 112, 'taskstatus:rejected:see', 4),
(592, 112, 'taskstatus:open:changeto', 4),
(593, 112, 'taskstatus:progress:changeto', 4),
(594, 112, 'taskstatus:confirm:changeto', 4),
(595, 112, 'taskstatus:rejected:changeto', 4),
(596, 112, 'taskstatus:open:edit', 4),
(597, 112, 'taskstatus:progress:edit', 4),
(598, 112, 'taskstatus:confirm:edit', 4),
(599, 112, 'taskstatus:rejected:edit', 4),
(600, 112, 'projectstatus:progress:see', 4),
(601, 112, 'projectstatus:warranty:see', 4),
(610, 106, 'person:seeAllInternalPersons', 2),
(611, 106, 'person:seeAllInternalPersons', 4),
(612, 106, 'person:seeAllPersons', 2),
(613, 106, 'person:seeAllPersons', 4),
(614, 106, 'company:seeAllCompanies', 2),
(615, 106, 'company:seeAllCompanies', 4),
(616, 119, 'task:editAllChargeable', 2),
(617, 115, 'general:area', 1),
(618, 115, 'filtersets:save', 1),
(619, 105, 'comment:editAll', 2),
(620, 105, 'comment:makePublic', 2),
(621, 105, 'comment:makePublic', 4),
(622, 105, 'comment:delete', 2),
(623, 112, 'task:editAndDeleteOwnTasks', 2),
(624, 112, 'taskstatus:planning:changefrom', 2),
(625, 112, 'taskstatus:open:changefrom', 2),
(626, 112, 'taskstatus:progress:changefrom', 2),
(627, 112, 'taskstatus:confirm:changefrom', 2),
(628, 112, 'taskstatus:done:changefrom', 2),
(629, 112, 'taskstatus:accepted:changefrom', 2),
(630, 112, 'taskstatus:rejected:changefrom', 2),
(631, 112, 'taskstatus:cleared:changefrom', 2),
(632, 112, 'taskstatus:planning:create', 2),
(633, 112, 'taskstatus:open:create', 2),
(634, 112, 'taskstatus:progress:create', 2),
(635, 112, 'taskstatus:confirm:create', 2),
(636, 112, 'taskstatus:done:create', 2),
(637, 112, 'taskstatus:accepted:create', 2),
(638, 112, 'taskstatus:rejected:create', 2),
(639, 112, 'taskstatus:cleared:create', 2),
(640, 112, 'task:editPersonOwner', 4),
(641, 112, 'task:editAndDeleteOwnTasks', 4),
(642, 112, 'taskstatus:planning:changefrom', 4),
(643, 112, 'taskstatus:open:changefrom', 4),
(644, 112, 'taskstatus:progress:changefrom', 4),
(645, 112, 'taskstatus:confirm:changefrom', 4),
(646, 112, 'taskstatus:done:changefrom', 4),
(647, 112, 'taskstatus:accepted:changefrom', 4),
(648, 112, 'taskstatus:rejected:changefrom', 4),
(649, 112, 'taskstatus:cleared:changefrom', 4),
(650, 112, 'taskstatus:planning:create', 4),
(651, 112, 'taskstatus:open:create', 4),
(652, 112, 'taskstatus:progress:create', 4),
(653, 112, 'taskstatus:confirm:create', 4),
(654, 112, 'taskstatus:done:create', 4),
(655, 112, 'taskstatus:accepted:create', 4),
(656, 112, 'taskstatus:rejected:create', 4),
(657, 112, 'taskstatus:cleared:create', 4),
(658, 112, 'projectstatus:planning:see', 4),
(659, 112, 'projectstatus:done:see', 4);
