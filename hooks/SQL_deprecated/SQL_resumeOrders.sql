
CREATE OR REPLACE VIEW SQL_resumeOrders AS 
SELECT
    `kind`,
    `company`,
    `typeDoc`,
    `customer`,
    SUM(`importoTot_Doc_PA`) AS 'TOT',
    MONTH(`date`) AS 'MONTH',
    YEAR(`date`) AS 'YEAR',
    COUNT(`multiOrder`) AS 'DOCs',
    `related`,
    MIN(`id`) AS 'id'
FROM
    `orders`
WHERE `typeDoc` = 'DDT'
    AND `kind` = 'OUT'
    AND `related` IS NULL
GROUP BY
    `kind`,
    `company`,
    `typeDoc`,
    `customer`,
    `related`