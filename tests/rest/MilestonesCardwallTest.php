<?php
/**
 * Copyright (c) Enalean, 2013. All rights reserved
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/
 */

require_once dirname(__FILE__).'/../lib/autoload.php';

/**
 * @group MilestonesTest
 */
class MilestonesCardwallTest extends RestBase {

    protected function getResponse($request) {
        return $this->getResponseByToken(
            $this->getTokenForUserName(TestDataBuilder::TEST_USER_1_NAME),
            $request
        );
    }

    /**
     * @expectedException Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testOPTIONSCardwallOnReleaseGives404() {
        $this->getResponse($this->client->options('milestones/'.TestDataBuilder::RELEASE_ARTIFACT_ID.'/cardwall'));
    }

    public function testOPTIONSCardwallOnSprintGivesOPTIONSandGET() {
        $response = $this->getResponse($this->client->options('milestones/'.TestDataBuilder::SPRINT_ARTIFACT_ID.'/cardwall'));
        $this->assertEquals(array('OPTIONS', 'GET'), $response->getHeader('Allow')->normalize()->toArray());
    }

    public function testGETCardwall() {
        $response = $this->getResponse($this->client->get('milestones/'.TestDataBuilder::SPRINT_ARTIFACT_ID.'/cardwall'));

        $cardwall = $response->json();

        $this->assertArrayHasKey('columns', $cardwall);
        $columns = $cardwall['columns'];
        $this->assertCount(4, $columns);

        $first_column = $columns[0];
        $this->assertEquals($first_column['id'], 1);
        $this->assertEquals($first_column['label'], "To be done");
        $this->assertEquals($first_column['color'], "#F8F8F8");

        $third_column = $columns[2];
        $this->assertEquals($third_column['id'], 3);
        $this->assertEquals($third_column['label'], "Review");
        $this->assertEquals($third_column['color'], "#F8F8F8");

        $this->assertArrayHasKey('swimlanes', $cardwall);
        $swimlanes = $cardwall['swimlanes'];
        $this->assertCount(2, $swimlanes);

        $first_swimlane = $swimlanes[0];

        $first_swimlane_card = $first_swimlane['cards'][0];
        $this->assertEquals(TestDataBuilder::SPRINT_ARTIFACT_ID.'_'.TestDataBuilder::STORY_1_ARTIFACT_ID, $first_swimlane_card['id']);
        $this->assertEquals("Believe", $first_swimlane_card['label']);
        $this->assertEquals("cards/".TestDataBuilder::SPRINT_ARTIFACT_ID."_".TestDataBuilder::STORY_1_ARTIFACT_ID, $first_swimlane_card['uri']);
        $this->assertEquals(TestDataBuilder::SPRINT_ARTIFACT_ID, $first_swimlane_card['planning_id']);
        $this->assertEquals("Open", $first_swimlane_card['status']);
        $this->assertEquals(null, $first_swimlane_card['accent_color']);
        $this->assertEquals("2", $first_swimlane_card['column_id']);
        $this->assertEquals(array(1,2,4), $first_swimlane_card['allowed_column_ids']);
        $this->assertEquals(array(), $first_swimlane_card['values']);

        $first_swimlane_card_project_reference = $first_swimlane_card['project'];
        $this->assertEquals(TestDataBuilder::PROJECT_PRIVATE_MEMBER_ID, $first_swimlane_card_project_reference['id']);
        $this->assertEquals("projects/".TestDataBuilder::PROJECT_PRIVATE_MEMBER_ID, $first_swimlane_card_project_reference['uri']);

        $first_swimlane_card_artifact_reference = $first_swimlane_card['artifact'];
        $this->assertEquals(TestDataBuilder::STORY_1_ARTIFACT_ID, $first_swimlane_card_artifact_reference['id']);
        $this->assertEquals("artifacts/".TestDataBuilder::STORY_1_ARTIFACT_ID, $first_swimlane_card_artifact_reference['uri']);

        $first_swimlane_card_artifact_tracker_reference = $first_swimlane_card_artifact_reference['tracker'];
        $this->assertEquals(TestDataBuilder::USER_STORIES_TRACKER_ID, $first_swimlane_card_artifact_tracker_reference['id']);
        $this->assertEquals('trackers/'.TestDataBuilder::USER_STORIES_TRACKER_ID, $first_swimlane_card_artifact_tracker_reference['uri']);
    }
}