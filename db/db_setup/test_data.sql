INSERT IGNORE INTO nodes
    (id, label, parent_id)
VALUES
    (1, 'node1', null),
    (2, 'node2', null),
    (3, 'node3', null),
    (4, 'node4', null),
    (5, 'node5', 1),
    (6, 'node6', 1),
    (7, 'node7', 1),
    (8, 'node8', 5),
    (9, 'node9', 5);

