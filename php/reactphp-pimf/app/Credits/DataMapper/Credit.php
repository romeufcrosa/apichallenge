<?php
namespace Credits\DataMapper;

use Pimf\DataMapper\Base;

class Credit extends Base
{
    /**
     * @param $id
     *
     * @return null|\Credits\Model\Credit
     */
    public function find($id)
    {
        $sth = $this->pdo->prepare(
            'SELECT * FROM enterprise_customerbalance WHERE customer_id = :customerId'
        );

        $sth->bindValue(':customerId', $id);

        $sth->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            '\Credits\Model\Credit',
            ['balance_id', 'customer_id', 'website_id', 'amount', 'base_currency_code']
        );

        $sth->execute();

        // let pdo fetch the User instance for you.
        $credit = $sth->fetch();

        if ($credit === false) {
            return null;
        }

        // set the protected id of user via reflection.
        $credit = $this->reflect($credit, (int)$id, 'customer_id');

        return $credit;
    }

    /**
     * @return \Credits\Model\Credit[]
     */
    public function getAll()
    {
        $sth = $this->pdo->prepare(
            'SELECT * FROM enterprise_customerbalance'
        );

        $sth->setFetchMode(
            \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
            '\Credits\Model\Credit',
            array('balance_id', 'customer_id', 'website_id', 'amount')
        );

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param \Credits\Model\Credit $credit
     *
     * @return int
     * @throws \RuntimeException
     */
    public function insert(\Credits\Model\Credit $credit)
    {
        $sth = $this->pdo->prepare(
            "INSERT INTO enterprise_customerbalance VALUES (NULL, :customerId, :websiteId, :amount, NULL)"
        );

        $sth->bindValue(':customerId', $credit->getCustomerId());
        $sth->bindValue(':websiteId', $credit->getWebsiteId());
        $sth->bindValue(':amount', $credit->getAmount());
        $sth->execute();

        $id = (int)$this->pdo->lastInsertId();

        return $id;
    }

    /**
     * @param \Credits\Model\Credit $credit
     *
     * @return bool
     */
    public function update(\Credits\Model\Credit $credit)
    {
        $sth = $this->pdo->prepare(
            "UPDATE enterprise_customerbalance SET amount = :amount WHERE customer_id = :customerId"
        );

        $sth->bindValue(':amount', $credit->getAmount());
        $sth->bindValue(':customerId', $credit->getCustomerId(), \PDO::PARAM_INT);

        $sth->execute();

        if ($sth->rowCount() == 1) {
            return true;
        }

        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $sth = $this->pdo->prepare(
            "DELETE FROM enterprise_customerbalance WHERE customer_id = :customer_id"
        );

        $sth->bindValue(':customer_id', $id, \PDO::PARAM_INT);
        $sth->execute();

        if ($sth->rowCount() == 0) {
            return false;
        }

        return true;
    }
}
