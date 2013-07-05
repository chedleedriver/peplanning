function drawObjectiveTabs(i) // i = lessonNum
{
	for (var objectiveId in window.objectiveIds[i])
	{
		doUpdateField('objectiveid',i,objectiveId,window.objectiveIds[i][objectiveId]);
		doUpdateField('objective',i,objectiveId,window.objectives[i][objectiveId]);
		doUpdateField('objectivestrand',i,objectiveId,window.objectiveStrand[i][objectiveId]);
		updateObjList(window.objectiveStrand[i][objectiveId],objectiveId,i);
	}
}
