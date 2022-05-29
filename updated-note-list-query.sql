SELECT Roles.role_id, Roles.role, Notes.note_id, Notes.title, Notes.create_at, Notes.last_modified, COUNT(Contributions.contribution_id) as Contribution_count
			FROM Roles LEFT JOIN Notes
			ON(Roles.note_id = Notes.note_id)
			LEFT JOIN Contributions
			ON(Roles.note_id = Contributions.note_id)
			WHERE Roles.user_id = '$user_id' AND Roles.role != 'none'
			GROUP BY Roles.role_id
			ORDER BY Notes.create_at DESC