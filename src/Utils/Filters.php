<?php


namespace KgBot\Mintsoft\Utils;


trait Filters
{

    protected function parseFilters( $filters = [] )
    {
        $urlFilters = '?APIKey=' . $this->request->getApiKey();

        if ( count( $filters ) > 0 ) {

            $urlFilters .= '&';
            $i          = 1;

            foreach ( $filters as $filter ) {

                $urlFilters .= $filter[ 0 ] . $filter[ 1 ] .
                               $this->escapeFilter( $filter[ 2 ] ); // todo fix arrays aswell ([1,2,3,...] string)

                if ( count( $filters ) > $i ) {

                    $urlFilters .= '&'; // todo allow $or: also
                }

                $i++;
            }
        }

        return $urlFilters;
    }

    private function escapeFilter( $variable )
    {
        $escapedStrings    = [
            "$",
            '(',
            ')',
            '*',
            '[',
            ']',
            ',',
        ];
        $urlencodedStrings = [
            '+',
            ' ',
        ];
        foreach ( $escapedStrings as $escapedString ) {

            $variable = str_replace( $escapedString, '$' . $escapedString, $variable );
        }
        foreach ( $urlencodedStrings as $urlencodedString ) {

            $variable = str_replace( $urlencodedString, urlencode( $urlencodedString ), $variable );
        }

        return $variable;
    }
}