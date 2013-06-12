function drawObjectiveTabs(i) // i = lessonNum
{
	for (var objectiveId in window.objectiveIds[i])
	{
		doUpdateField('objectiveid',i,window.objectiveIds[i][objectiveId],window.objectiveIds[i][objectiveId]);
		doUpdateField('objective',i,window.objectiveIds[i][objectiveId],window.objectives[i][objectiveId]);
		doUpdateField('objectivestrand',i,window.objectiveIds[i][objectiveId],window.objectiveStrand[i][objectiveId]);
		updateObjList(window.objectiveStrand[i][objectiveId],window.objectiveIds[i][objectiveId],i);
	}
}
