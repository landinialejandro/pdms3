/**
 * Author:  Alejandro Landini <landinialejandro@gmail.com>
 * Created: 20 sep. 2018
 */
CREATE OR REPLACE VIEW SQL_companiesAddresses AS 
SELECT
    companies.id,
    addresses_PA.id AS addressId,
    addresses_PA.kind,
    addresses_PA.address,
    addresses_PA.houseNumber,
    addresses_PA.country,
    addresses_PA.town,
    addresses_PA.postalCode,
    addresses_PA.district,
    addresses_PA.default,
    addresses_PA.ship
FROM
    companies
LEFT OUTER JOIN addresses_PA ON addresses_PA.company = companies.id
WHERE
    addresses_PA.id IS NOT NULL